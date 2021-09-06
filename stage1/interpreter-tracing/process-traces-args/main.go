package main

import (
	"bufio"
	"fmt"
	"os"
	"path/filepath"
	"strconv"
	"strings"
)

var functions map[string]map[string]map[string]bool
var children map[int]string
var syscallnr_name map[int]string
var syscall_args_indices map[string][]int
 var path = "/root/stage1/interpreter-static-analysis/"

func syscallnr_to_name() {
	syscallnr_name = make(map[int]string)
	f, err := os.Open(path + "syscalls.txt")
	if err != nil {
		panic(err)
	}
	defer f.Close()
	scanner := bufio.NewScanner(f)
	for scanner.Scan() {
		line := scanner.Text()
		result := strings.Fields(line)
		syscall_name := result[0]
		syscall_nr, _ := strconv.Atoi(result[1])
		syscallnr_name[syscall_nr] = syscall_name
	}
}

// Reads from the nopointersyscallargs file to denote the indices of the arguments per system call
// that should be used in the seccomp filter
func read_nopointer() {
	syscall_name := ""
	syscall_args_indices = make(map[string][]int)
    syscall_args_file, err := os.Open(path + "nopointersyscallargs.txt")
    if err != nil {
		panic(err)
	}
	defer syscall_args_file.Close()
	scanner := bufio.NewScanner(syscall_args_file)
    for scanner.Scan() {
    	indices := []int{}
    	line := scanner.Text()
    	if line != "" {
    		split := strings.SplitN(line, " ", 3)
    		syscall_nr,_ := strconv.Atoi(split[0])
    		syscall_name = syscallnr_name[syscall_nr]
    		nr_of_indices,_ := strconv.Atoi(split[1])
    		if nr_of_indices == 0 {
    			syscall_args_indices[syscall_name] = indices
    			continue
    		}
    		args_indices := strings.Split(split[2], ",")
    		for _,arg_index := range args_indices[:len(args_indices)-1] {
    			arg_index_int,_ := strconv.Atoi(arg_index)
    			indices = append(indices, arg_index_int)
    		}
    	}
    	syscall_args_indices[syscall_name] = indices
    }
}

// splitArguments splits arguments separated by comma and space,
// and takes care of ignoring these instances when within a string or struct argument
func splitArguments(arguments string) []string {
	guard_bracket := 0
	guard_quote := true
	guard_square_bracket := 0
	guard_comment := false
	split_args := []string{}
	split_args = append(split_args, "")
	for index, element := range arguments {
		if index > 0 && string(arguments[index-1]) == `\` {
			continue
		}
		if guard_comment {
			if element == '/' && arguments[index-1] == '*' {
				guard_comment = false
			}
			continue
		}
		if guard_quote && element == '/' && index != len(arguments) && arguments[index+1] == '*' {
			guard_comment = true
			continue
		}
		if guard_bracket == 0 && guard_quote && guard_square_bracket == 0 && element == ',' && index != len(arguments) && arguments[index+1] == ' ' {
			split_args = append(split_args, "")
		} else if element == ',' {
			split_args[len(split_args)-1] += "."
		} else {
			split_args[len(split_args)-1] += string(element)
		}
		if guard_quote && element == '{' {
			guard_bracket += 1
		}
		if guard_quote && element == '}' {
			guard_bracket -= 1 
		}
		if guard_quote && element == '[' {
			guard_square_bracket += 1
		}
		if guard_quote && element == ']' {
			guard_square_bracket -= 1
		}
		if element == '"' {
			guard_quote = !guard_quote
		}
	}
	return split_args
}

// processFile reads the trace files and determines which system calls (and arguments)
// belong to which function
func processFile(path string) {
	f, err := os.Open(path)
	if err != nil {
		panic(err)
	}
	defer f.Close()

	splitPath := strings.Split(path, ".")
	pid, _ := strconv.Atoi(splitPath[len(splitPath)-1])
	inCallstack := false
	callstack := []string{}
	scn := ""
	args_filtered := ""
	scc := -1
	scp := true
	validity := true
	scanner := bufio.NewScanner(f)
	for scanner.Scan() {
		l := scanner.Text()
		if l == " --- php call stack starts ---" {
			inCallstack = true
			callstack = []string{}
		} else if l == " --- php call stack ends ---" {
			inCallstack = false
			if len(callstack) > 0 && scn != "" && validity {
				fn := callstack[0]
				if _, ok := functions[fn]; !ok {
					functions[fn] = make(map[string]map[string]bool)
				}
				if _, ok := functions[fn][scn]; !ok {
					functions[fn][scn] = make(map[string]bool)
				}
				functions[fn][scn][args_filtered] = true
				if scn == "clone" {
					children[scc] = fn
				}
			}
			scn = ""
			scp = true
			validity = true
		} else if inCallstack {
			s := strings.Split(l, " ")
			if len(s) >= 3 {
				callstack = append(callstack, s[2])
			}
		} else {
			if _, err := strconv.Atoi(l); err != nil {
				s := strings.Split(l, " ")
				if len(s) > 0 {
					// split line to find system call name and syscall arguments
					args_filtered = ""
					scn = strings.Split(s[0], "(")[0]
					ss := strings.Split(l, "=")
					return_val := ss[len(ss)-1]
					if strings.Contains(return_val, "-1") { //system call returned with error
						validity = false 
					}
					if strings.Contains(s[0], "(") {
						split := strings.SplitN(l, "(",2)[1]
						index := strings.LastIndex(split, "=")
						split = split[:index]
						last_index := strings.LastIndex(split, ")")
						args := splitArguments(split[:last_index])
						indices := syscall_args_indices[scn]
						for _, index := range indices {
							if index >= len(args) {
								args_filtered = args_filtered + "not available, "
							} else {
								args_filtered = args_filtered + args[index] + ", "
							}

						}
					}
					if pf, ok := children[pid]; ok && !scp {
						if _, ok := functions[pf]; !ok {
							functions[pf] = make(map[string]map[string]bool)
						}
						if _, ok := functions[pf][scn]; !ok {
							functions[pf][scn] = make(map[string]bool)
						}
						functions[pf][scn][args_filtered] = true
					}
					if scn == "clone" {
						scc, _ = strconv.Atoi(s[len(s)-1])
						if pf, ok := children[pid]; ok {
							functions[pf][scn][args_filtered] = true
						}
					}
				}
			}
			scp = false
		}
	}
}

func main() {
	if len(os.Args) != 2 {
		fmt.Printf("Usage: ./process-traces TRACE_DIR \n")
		os.Exit(0)
	}

	syscallnr_to_name()
	read_nopointer()

	path := os.Args[1]
	fileList := []string{}

	functions = make(map[string]map[string]map[string]bool)
	children = make(map[int]string)

	filepath.Walk(path, func(path string, f os.FileInfo, err error) error {
		fileList = append(fileList, path)
		return nil
	})
	for _, f := range fileList {
		processFile(f)

	}
	for fn, scs := range functions {
		fmt.Printf("%s: ", fn)
		for sc, scas := range scs {
			fmt.Printf("%s: ", sc)
			for sca, _ := range scas {
				fmt.Printf("(%s),,, ", sca) // print with triple comma to distinguish from comma in string argument.
			}
			fmt.Printf(";;;")
		}
		fmt.Printf("\n")
	}
}