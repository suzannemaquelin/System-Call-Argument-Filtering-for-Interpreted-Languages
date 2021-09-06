/*
   +----------------------------------------------------------------------+
   | PHP Version 7                                                        |
   +----------------------------------------------------------------------+
   | Copyright (c) 1997-2018 The PHP Group                                |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author:                                                              |
   +----------------------------------------------------------------------+
   */

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "zend_builtin_functions.h"
#include "php_seccomp.h"
#include <seccomp.h>
#include <linux/filter.h>
#include <stdio.h>
#include <stdlib.h> 
#include "seccomp-bpf.h"
#include "uthash.h"
#include <stdbool.h>
#include <limits.h>


#define NUM_BUCKETS 50000
#define DELIM ' '

#ifndef SYS_SECCOMP
#define SYS_SECCOMP 1
#endif

#if defined(__i386__)
#define REG_SYSCALL REG_EAX
#define ARCH_NR AUDIT_ARCH_I386
#elif defined(__x86_64__)
#define REG_SYSCALL REG_RAX
#define ARCH_NR AUDIT_ARCH_X86_64
#else
#error "Platform does not support seccomp filter yet"
#define REG_SYSCALL 0
#define ARCH_NR 0
#endif

static int trapped = 0;

int filter[NUM_BUCKETS][347];
int filter_count[NUM_BUCKETS];
scmp_filter_ctx ctx;

#if PHP_MAJOR_VERSION < 7
void (*seccomp_old_execute_internal)(zend_execute_data *execute_data_ptr,
                                     struct _zend_fcall_info *fci,
                                     int return_value_used TSRMLS_DC);
void seccomp_execute_internal(zend_execute_data *execute_data_ptr,
                              struct _zend_fcall_info *fci,
                              int return_value_used TSRMLS_DC);
#else
void (*seccomp_old_execute_internal)(zend_execute_data *current_execute_data,
                                     zval *return_value);
void seccomp_execute_internal(zend_execute_data *current_execute_data,
                              zval *return_value);
#endif

static void seccomp_trap_handler(int signal, siginfo_t *info, void *vctx);
int seccomp_trap_install();

int seccomp_loaded = 0;

struct sock_filter_wrapper {
  struct sock_filter *filter;
  int len;
};

struct node {
   int *data;
   int *datainfo;
   int key;
   struct node *next;
};

struct filter {
  struct node* syscall_args[347];
  int syscalls[347];
  char name[512];
  int len;
  UT_hash_handle hh;
};

struct arginfo {
  int scn;
  int nr_args;
  int* args;
};

struct arginfo *info = NULL;

struct filter *filters = NULL;

/* True global resources - no need for thread safety here */
static int le_seccomp;

PHP_INI_BEGIN()
    PHP_INI_ENTRY("seccomp.enable", "0", PHP_INI_ALL, NULL)
    PHP_INI_ENTRY("seccomp.profile_path", "", PHP_INI_ALL, NULL)
    PHP_INI_ENTRY("seccomp.db_path", "", PHP_INI_ALL, NULL)
    PHP_INI_ENTRY("seccomp.app_base", "", PHP_INI_ALL, NULL)
PHP_INI_END()

PHP_FUNCTION(confirm_seccomp_compiled) {
  char *arg = NULL;
  size_t arg_len, len;

  if (zend_parse_parameters(ZEND_NUM_ARGS(), "s", &arg, &arg_len) == FAILURE) {
    return;
  }
}

unsigned long hash(char *str) {
  unsigned long hash = 5381;
  int c;
  while ((c = *str++))
    hash = ((hash << 5) + hash) + c; /* hash * 33 + c */
  return hash % NUM_BUCKETS;
}

/** 
 * Reads from nopointersyscallargs.txt to fill the struct arginfo pointer info with the following information per system call:
 * system call number, number of arguments, index of each argument.
*/
void initializeArgs() {
  char *path = "/root/stage1/interpreter-static-analysis/nopointersyscallargs.txt";
  char *line = NULL;
  size_t len = 0;
  ssize_t read;
  int scn;
  int nr_args;

  // read file to find out what is the highest number of syscalls
  FILE *fp = fopen(path, "r");
  if (fp == NULL) {
    printf("failure to open %s\n", path);
  }
  while ((read = getline(&line, &len, fp)) != -1) {
    scn = atoi(line);
  }
  fclose(fp);

  // put all info from file into struct array
  info = malloc((scn+1) * sizeof(struct arginfo));
  fp = fopen(path, "r");
  if (fp == NULL) {
    printf("failure to open %s\n", path);
  }
  while ((read = getline(&line, &len, fp)) != -1) {
    scn = atoi(line);
    info[scn].scn = scn;
    int index = strcspn(line, " ");
    nr_args = atoi(line + index + 1);
    info[scn].nr_args = nr_args;
    if(nr_args) {
      info[scn].args = malloc(nr_args * sizeof(int));
      int j = 0;
      int index_2 = strcspn(line + index + 1, " ");
      info[scn].args[j++] = atoi((line + index + 1 + index_2));
      for(int i = 0; i < strlen(line); i++){
          if(line[i] == ',') {
            info[scn].args[j++] = atoi((line + i + 1));
        }
      }
    }
  }
  free(line);
  fclose(fp);
}

///////// linked list functionality //////////
//// taken from: https://www.tutorialspoint.com/data_structures_algorithms/linked_list_program_in_c.htm ////
struct node *head = NULL;
struct node *current = NULL;

//insert link at the first location
void insertFirst(int key, int data[], int datainfo[], int n) {
   //create a link
   struct node *link = (struct node*) malloc(sizeof(struct node));
   
   link->key = key;
   link->data = malloc(n * sizeof(int));
   link->datainfo = malloc(n * sizeof(int));
   // link->data = data;
   memcpy(link->data, data, n * sizeof(int));
   memcpy(link->datainfo, datainfo, n * sizeof(int));
   
   //point it to old first node
   link->next = head;
   
   //point first to new first node
   head = link;
}
//////// end functionality ///////

/**
 * Split arguments in argument set that are comma separated. 
 * For each argument we determine whether they are initialized.
 * Each argument set is added to a next node in a linked list.
*/
void split_and_evaluate_args(char *syscallargs[], struct node* row[], int length, int syscalls[]) {
  for (int index=0; index < length; index++) {
    row[index] = NULL;
    int i = 0;
    char *args = syscallargs[index];
    while (args) {
      int index_space = strcspn(args, " ");
      int guard = 0;
      int j = 0;
      int scn = syscalls[index];
      int n = 10; //number of arguments never exceeds 10
      int arg_arr[n];
      int initialized[n]; //denote whether argument is initialized
      char *arg = args;
      while(index_space > (guard + 1)) {
        int index_comma = strcspn(arg, ","); //arguments are comma separated
        char one_arg[index_comma+1];
        strncpy(one_arg, arg, index_comma);
        one_arg[index_comma] = '\0';
        char uninitialized[14] = "UNINITIALIZED";
        arg_arr[j] = atoi(one_arg);
        if (strcmp(one_arg, uninitialized)!=0) {
          initialized[j] = 1;
        } else {
          initialized[j] = 0;
        }
        j++;
        arg = &arg[index_comma+1];
        if (!arg) {
          break;
        }
        guard += index_comma+1;
      }
      insertFirst(i++, arg_arr, initialized, n);
      args = &args[index_space+1];
      if (args[0]=='\0' || args[1]=='\0') {
        break;
      }
    }
    row[index] = head;
    head = NULL;
    current = NULL;
  }
}

/**
 * Keeps track of which system calls have arguments that are restricted and which do not. 
 * Purely for informational purposes. 
*/
void which_restricted(struct filter *s, int (*noargssyscalls)[347], int (*withargssyscalls)[347]) {
  for (int j = 0; j < s->len; j++) {
    struct node* args = s->syscall_args[j];
    if (!args || !info[s->syscalls[j]].nr_args) { // no arguments
      (*noargssyscalls)[s->syscalls[j]] = 1;
    }
    while(args) {
      switch(evaluate(info[s->syscalls[j]].nr_args, args)) {
        case 0:
          (*noargssyscalls)[s->syscalls[j]] = 1;
          break;
        default:
          (*withargssyscalls)[s->syscalls[j]] = 1;
      }
      args = args->next;
    }
  }
}

/**
 * PHP_MINIT_FUNCTION is run as the module startup step, before PHP_RINIT_FUNCTION.
 * Here, it reads from file the system calls and arguments per script that should be allowed by the seccomp filter
 * The information per system call is saved to a linked list structure for later use.
 * Thereafter it prints which system call's arguments are restricted.
*/
PHP_MINIT_FUNCTION(seccomp) {
  initializeArgs();

  char *syscall_args[347];
  int syscalls[347];
  char *line = NULL;
  size_t len = 0;
  ssize_t read;
  int i = 0;

  //for printing purposes only
  int noargssyscalls[347] = {0};
  int withargssyscalls[347] = {0};

  seccomp_old_execute_internal = zend_execute_internal;
  zend_execute_internal = seccomp_execute_internal;
  REGISTER_INI_ENTRIES();

  if (!INI_STR("seccomp.enable")) {
    return SUCCESS;
  }
  FILE *fp = fopen(INI_STR("seccomp.profile_path"), "r");
  if (fp == NULL)
    return FAILURE;
  struct filter *s = (struct filter *)malloc(sizeof *s);
  while ((read = getline(&line, &len, fp)) != -1) {
    if (line[0] == '/') { // new script introduces new name
      strcpy(s->name, line);
      int index_newline = strcspn(s->name, "\n");
      s->name[index_newline] = '\0';
      continue;
    } else if (line[0] == '\n') { //end of syscall list for script
      s->len = i;
      // transfer gathered arguments per system call to filter struct s
      split_and_evaluate_args(syscall_args, s->syscall_args, i, s->syscalls);
      // denote per system call whether they have arguments that can be restricted
      which_restricted(s, &noargssyscalls, &withargssyscalls);

      // reset variables for next script and add information to filter
      i = 0;
      HASH_ADD_STR(filters, name, s);
      s = (struct filter *)malloc(sizeof *s);
    } else { // system call number with argument list separated by spaces
      char *syscall = line;
      syscall[0] = '\0';
      int scn = atoi(syscall+1);
      s->syscalls[i] = scn;

      int index_space = strcspn(syscall+1, " ");
      char *args = (char*)malloc(read-index_space);
      strcpy(args, syscall+1+index_space);
      if (args) {
        args[0] = '\0';
      }
      syscall_args[i] = args + 1;
      if (read - index_space < 4) {
        syscall_args[i] = NULL;
      }
      i++; 
    }
  }

  printf("syscalls no args: ");
  for (int k=0; k < 347; k++) {
    if (noargssyscalls[k] == 1) {
      printf("%d, ", k);
    }
  }
  printf("\n");

  printf("syscalls with args: ");
  for (int k=0; k < 347; k++) {
    if (withargssyscalls[k] == 1) {
      printf("%d, ", k);
    }
  }
  printf("\n");

  if ((ctx = seccomp_init(SCMP_ACT_KILL)) == NULL) {
    zend_error(E_NOTICE, "unable to initialize libseccomp subsystem");
  }
  // Add the essentials
  seccomp_rule_add(ctx, SECCOMP_RET_KILL, SCMP_SYS(exit), 0);

  return SUCCESS;
}

int** createArray(int m, int n)
{
    int* values = calloc(m*n, sizeof(int));
    int** rows = malloc(m*sizeof(int*));
    for (int i=0; i<m; ++i)
    {
        rows[i] = values + i*n;
    }
    return rows;
}

void destroyArray(int** arr)
{
    free(*arr);
    free(arr);
}

/**
 * Creates a double array with permutations.
 * Each index is either zero or one.
 * The number of permutations is equal to 2 to the power number,
 * where number gives the number of entries to be permuted.
 */ 
int** permute(int number, int number_of_permutations) {
   int **arr = createArray(number_of_permutations, number);
   for (int i = 0; i < number_of_permutations; i++) {
      for (int j=0; j < number; j++) {
         arr[number_of_permutations-i-1][number - j -1] = (int) (i & ( 1 << j )) >> j;
      }
   }
   return arr;
}

/**
 * Checks all possible permutations and evaluates whether that permutation is allowed.
 * A permutation is allowed when the arguments at indices for which the permutation is 1
 * are available and do not exceed the seccomp limit.
 * When such a permutation is found, it converts the bits of the permutation to an integer.
 */
int evaluate(int number, struct node* args) {
  int N = (int) pow(2.0, (double) number);
  int **permutations = createArray(N, number);
  permutations = permute(number, N);
  int correct;
  for (int i = 0; i < N; i++) {
    correct = 0;
    for (int j = 0; j < number; j++) {
      if (!permutations[i][j]) {
        correct += 1;
      } else if (args->datainfo[j] && args->data[j] < 32768) {
        correct += 1;
      }
    }
    if (correct == number) {
      int evaluation = 0;
      for (int j = 0; j < number; j++) {
         evaluation += (int) (permutations[i][j] << j);
      }
      return evaluation;
    }
  }
}

PHP_MSHUTDOWN_FUNCTION(seccomp) {
  UNREGISTER_INI_ENTRIES();
  return SUCCESS;
}

PHP_RINIT_FUNCTION(seccomp) {
#if defined(COMPILE_DL_SECCOMP) && defined(ZTS)
  ZEND_TSRMLS_CACHE_UPDATE();
#endif
  return SUCCESS;
}

PHP_RSHUTDOWN_FUNCTION(seccomp) { return SUCCESS; }

PHP_MINFO_FUNCTION(seccomp) {
  php_info_print_table_start();
  php_info_print_table_header(2, "seccomp support", "enabled");
  php_info_print_table_end();
}

const zend_function_entry seccomp_functions[] = {
    PHP_FE(confirm_seccomp_compiled, NULL) /* For testing, remove later. */
    PHP_FE_END /* Must be the last line in seccomp_functions[] */
};

zend_module_entry seccomp_module_entry = {
    STANDARD_MODULE_HEADER,
    "seccomp",
    seccomp_functions,
    PHP_MINIT(seccomp),
    PHP_MSHUTDOWN(seccomp),
    PHP_RINIT(seccomp), /* Replace with NULL if there's nothing to do at request
                           start */
    PHP_RSHUTDOWN(seccomp), /* Replace with NULL if there's nothing to do at
                               request end */
    PHP_MINFO(seccomp),
    PHP_SECCOMP_VERSION,
    STANDARD_MODULE_PROPERTIES};

int load_seccomp_profile() {
  const char *script_path;
  HashTable *_SERVER;
  _SERVER = Z_ARRVAL(PG(http_globals)[TRACK_VARS_SERVER]);
  if(!_SERVER)
    script_path = zend_get_executed_filename();
  else {
    zval *data = zend_hash_str_find(_SERVER, "SCRIPT_FILENAME", sizeof("SCRIPT_FILENAME")-1);
    script_path= Z_STRVAL_P(data);
  }
  if (strlen(script_path) < strlen(INI_STR("seccomp.app_base"))) {
    return -1;
  }
  char *relative_path = script_path + strlen(INI_STR("seccomp.app_base"));


  int h = hash(relative_path);

  int sc_rc;

  if (!INI_INT("seccomp.enable"))
    return -1;

  struct filter *s = (struct filter *)malloc(sizeof *s);
  HASH_FIND_STR(filters, relative_path, s);
  // FPM 7.1-specific syscalls
  seccomp_rule_add(ctx, SCMP_ACT_ALLOW, 100, 0);
  seccomp_rule_add(ctx, SCMP_ACT_ALLOW, 80, 0);
  seccomp_rule_add(ctx, SCMP_ACT_ALLOW, 38, 0);
  seccomp_rule_add(ctx, SCMP_ACT_ALLOW, 273, 0);
  seccomp_rule_add(ctx, SCMP_ACT_ALLOW, 48, 0);
  if (s) {
    for (int i = 0; i < s->len; i++) {
      struct node* args = s->syscall_args[i];
      int n = info[s->syscalls[i]].nr_args;
      if (!args || !n) {
        seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 0);
      }
      while (args) {    
        int evaluation = evaluate(n, args);
        switch(evaluation) { // the maximum number of arguments is 5, so at most 32 cases.
          case 0:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 0);
            break;
          case 1: 
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 1, SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]));
            break;
          case 2:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 1, SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]));
            break;
          case 3:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
                SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
                SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]));
            break;
          case 4:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 1, 
                SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]));
            break;
          case 5:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
                SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
                SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]));
            break;
          case 6:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
                SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
                SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]));
            break;
          case 7:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
                SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
                SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
                SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]));
            break;
          case 8:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 1, 
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 9:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 10:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 11:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 12:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 13:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 14:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 15:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 4, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]));
            break;
          case 16:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 1,
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 17:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 18:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 19:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 20:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 4, 
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 21:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 22:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 23:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 4, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 24:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 2, 
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 25:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 26:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 27:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 4, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 28:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 3, 
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 29:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 4, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 30:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 4, 
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          case 31:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 5, 
              SCMP_CMP(info[s->syscalls[i]].args[0], SCMP_CMP_EQ, args->data[0]),
              SCMP_CMP(info[s->syscalls[i]].args[1], SCMP_CMP_EQ, args->data[1]),
              SCMP_CMP(info[s->syscalls[i]].args[2], SCMP_CMP_EQ, args->data[2]),
              SCMP_CMP(info[s->syscalls[i]].args[3], SCMP_CMP_EQ, args->data[3]),
              SCMP_CMP(info[s->syscalls[i]].args[4], SCMP_CMP_EQ, args->data[4]));
            break;
          default:
            seccomp_rule_add(ctx, SCMP_ACT_ALLOW, s->syscalls[i], 0);
            printf("default\n");
        }   
        // go to next node
        args = args->next;
      }
    }
  }

  sc_rc = seccomp_load(ctx);

  return sc_rc;
}

void seccomp_execute_internal(zend_execute_data *current_execute_data,
                              zval *return_value) {
  if (!seccomp_loaded && INI_STR("seccomp.enable")) {
    load_seccomp_profile();
    seccomp_loaded = 1;
  } else {
    zend_execute_internal = seccomp_old_execute_internal;
  }
  if (seccomp_old_execute_internal) {
    seccomp_old_execute_internal(current_execute_data, return_value TSRMLS_CC);
  } else {
    execute_internal(current_execute_data, return_value TSRMLS_CC);
  }
}

#ifdef COMPILE_DL_SECCOMP
#ifdef ZTS
ZEND_TSRMLS_CACHE_DEFINE()
#endif
ZEND_GET_MODULE(seccomp)
#endif

