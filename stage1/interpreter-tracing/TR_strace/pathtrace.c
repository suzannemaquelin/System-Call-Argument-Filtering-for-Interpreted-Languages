/*
 * Copyright (c) 2011 Comtrol Corp.
 * Copyright (c) 2011-2020 The strace developers.
 * All rights reserved.
 *
 * SPDX-License-Identifier: LGPL-2.1-or-later
 *
 */

#include "defs.h"
#include <limits.h>
#include <poll.h>

#include "number_set.h"
#include "syscall.h"
#include "xstring.h"

struct path_set global_path_set;

/*
 * Return true if specified path matches one that we're tracing.
 */
static bool
pathmatch(const char *path, struct path_set *set)
{
	unsigned i;

	for (i = 0; i < set->num_selected; ++i) {
		if (strcmp(path, set->paths_selected[i]) == 0)
			return true;
	}
	return false;
}

/*
 * Return true if specified path (in user-space) matches.
 */
static bool
upathmatch(struct tcb *const tcp, const kernel_ulong_t upath,
	   struct path_set *set)
{
	char path[PATH_MAX + 1];

	return umovestr(tcp, upath, sizeof(path), path) > 0 &&
		pathmatch(path, set);
}

/*
 * Return true if specified fd maps to a path we're tracing.
 */
static bool
fdmatch(struct tcb *tcp, int fd, struct path_set *set)
{
	char path[PATH_MAX + 1];
	int n = getfdpath(tcp, fd, path, sizeof(path));

	return n >= 0 && pathmatch(path, set);
}

/*
 * Add a path to the set we're tracing.
 * Specifying NULL will delete all paths.
 */
static void
storepath(const char *path, struct path_set *set)
{
	if (pathmatch(path, set))
		return; /* already in table */

	if (set->num_selected >= set->size)
		set->paths_selected =
			xgrowarray(set->paths_selected, &set->size,
				   sizeof(set->paths_selected[0]));

	set->paths_selected[set->num_selected++] = path;
}

/*
 * Get path associated with fd of a process with pid.
 */
int
getfdpath_pid(pid_t pid, int fd, char *buf, unsigned bufsize)
{
	char linkpath[sizeof("/proc/%u/fd/%u") + 2 * sizeof(int)*3];
	ssize_t n;

	if (fd < 0)
		return -1;

	int proc_pid = 0;
	translate_pid(NULL, pid, PT_TID, &proc_pid);
	if (!proc_pid)
		return -1;

	xsprintf(linkpath, "/proc/%u/fd/%u", proc_pid, fd);
	n = readlink(linkpath, buf, bufsize - 1);
	/*
	 * NB: if buf is too small, readlink doesn't fail,
	 * it returns truncated result (IOW: n == bufsize - 1).
	 */
	if (n >= 0)
		buf[n] = '\0';
	return n;
}

/*
 * Add a path to the set we're tracing.  Also add the canonicalized
 * version of the path.  Specifying NULL will delete all paths.
 */
void
pathtrace_select_set(const char *path, struct path_set *set)
{
	char *rpath;

	storepath(path, set);

	rpath = realpath(path, NULL);

	if (rpath == NULL)
		return;

	/* if realpath and specified path are same, we're done */
	if (strcmp(path, rpath) == 0) {
		free(rpath);
		return;
	}

	if (!is_number_in_set(QUIET_PATH_RESOLVE, quiet_set)) {
		char *path_quoted = xmalloc(strlen(path) * 4 + 4);
		char *rpath_quoted = xmalloc(strlen(rpath) * 4 + 4);

		string_quote(path, path_quoted, strlen(path) + 1,
			     QUOTE_0_TERMINATED, NULL);
		string_quote(rpath, rpath_quoted, strlen(rpath) + 1,
			     QUOTE_0_TERMINATED, NULL);

		error_msg("Requested path %s resolved into %s",
			  path_quoted, rpath_quoted);

		free(path_quoted);
		free(rpath_quoted);
	}
	storepath(rpath, set);
}

static bool
match_xselect_args(struct tcb *tcp, const kernel_ulong_t *args,
		   struct path_set *set)
{
	/* Kernel truncates arg[0] to int, we do the same. */
	int nfds = (int) args[0];
	/* Kernel rejects negative nfds, so we don't parse it either. */
	if (nfds <= 0)
		return false;
	/* Beware of select(2^31-1, NULL, NULL, NULL) and similar... */
	if (nfds > 1024*1024)
		nfds = 1024*1024;
	unsigned int fdsize = (((nfds + 7) / 8) + current_wordsize-1) & -current_wordsize;
	fd_set *fds = xmalloc(fdsize);

	for (unsigned int i = 1; i <= 3; ++i) {
		if (args[i] == 0)
			continue;
		if (umoven(tcp, args[i], fdsize, fds) < 0)
			continue;
		for (int j = 0;; ++j) {
			j = next_set_bit(fds, j, nfds);
			if (j < 0)
				break;
			if (fdmatch(tcp, j, set)) {
				free(fds);
				return true;
			}
		}
	}

	free(fds);
	return false;
}

/*
 * Return true if syscall accesses a selected path
 * (or if no paths have been specified for tracing).
 */
bool
pathtrace_match_set(struct tcb *tcp, struct path_set *set)
{
	const struct_sysent *s;

	s = tcp_sysent(tcp);

	if (!(s->sys_flags & (TRACE_FILE | TRACE_DESC | TRACE_NETWORK)))
		return false;

	/*
	 * Check for special cases where we need to do something
	 * other than test arg[0].
	 */

	switch (s->sen) {
	case SEN_close_range:
	case SEN_dup2:
	case SEN_dup3:
	case SEN_kexec_file_load:
	case SEN_sendfile:
	case SEN_sendfile64:
	case SEN_tee:
		/* fd, fd */
		return fdmatch(tcp, tcp->u_arg[0], set) ||
			fdmatch(tcp, tcp->u_arg[1], set);

	case SEN_execveat:
	case SEN_faccessat:
	case SEN_faccessat2:
	case SEN_fchmodat:
	case SEN_fchownat:
	case SEN_fspick:
	case SEN_fstatat64:
	case SEN_futimesat:
	case SEN_inotify_add_watch:
	case SEN_mkdirat:
	case SEN_mknodat:
	case SEN_name_to_handle_at:
	case SEN_newfstatat:
	case SEN_open_tree:
	case SEN_openat:
	case SEN_openat2:
	case SEN_readlinkat:
	case SEN_statx:
	case SEN_unlinkat:
	case SEN_utimensat_time32:
	case SEN_utimensat_time64:
		/* fd, path */
		return fdmatch(tcp, tcp->u_arg[0], set) ||
			upathmatch(tcp, tcp->u_arg[1], set);

	case SEN_link:
	case SEN_mount:
	case SEN_pivotroot:
		/* path, path */
		return upathmatch(tcp, tcp->u_arg[0], set) ||
			upathmatch(tcp, tcp->u_arg[1], set);

	case SEN_quotactl:
	case SEN_symlink:
		/* x, path */
		return upathmatch(tcp, tcp->u_arg[1], set);

	case SEN_linkat:
	case SEN_move_mount:
	case SEN_renameat2:
	case SEN_renameat:
		/* fd, path, fd, path */
		return fdmatch(tcp, tcp->u_arg[0], set) ||
			fdmatch(tcp, tcp->u_arg[2], set) ||
			upathmatch(tcp, tcp->u_arg[1], set) ||
			upathmatch(tcp, tcp->u_arg[3], set);

#if HAVE_ARCH_OLD_MMAP
	case SEN_old_mmap:
# if HAVE_ARCH_OLD_MMAP_PGOFF
	case SEN_old_mmap_pgoff:
# endif
	{
		kernel_ulong_t *args =
			fetch_indirect_syscall_args(tcp, tcp->u_arg[0], 6);

		return args && fdmatch(tcp, args[4], set);
	}
#endif /* HAVE_ARCH_OLD_MMAP */

	case SEN_mmap:
	case SEN_mmap_4koff:
	case SEN_mmap_pgoff:
	case SEN_ARCH_mmap:
		/* x, x, x, x, fd */
		return fdmatch(tcp, tcp->u_arg[4], set);

	case SEN_symlinkat:
		/* x, fd, path */
		return fdmatch(tcp, tcp->u_arg[1], set) ||
			upathmatch(tcp, tcp->u_arg[2], set);

	case SEN_copy_file_range:
	case SEN_splice:
		/* fd, x, fd, x, x, x */
		return fdmatch(tcp, tcp->u_arg[0], set) ||
			fdmatch(tcp, tcp->u_arg[2], set);

	case SEN_epoll_ctl:
		/* x, x, fd, x */
		return fdmatch(tcp, tcp->u_arg[2], set);


	case SEN_fanotify_mark:
	{
		/* x, x, mask (64 bit), fd, path */
		unsigned long long mask = 0;
		int argn = getllval(tcp, &mask, 2);
		return fdmatch(tcp, tcp->u_arg[argn], set) ||
			upathmatch(tcp, tcp->u_arg[argn + 1], set);
	}
#if HAVE_ARCH_OLD_SELECT
	case SEN_oldselect:
	{
		kernel_ulong_t *args =
			fetch_indirect_syscall_args(tcp, tcp->u_arg[0], 5);

		return args && match_xselect_args(tcp, args, set);
	}
#endif
	case SEN_pselect6_time32:
	case SEN_pselect6_time64:
	case SEN_select:
		return match_xselect_args(tcp, tcp->u_arg, set);
	case SEN_poll_time32:
	case SEN_poll_time64:
	case SEN_ppoll_time32:
	case SEN_ppoll_time64:
	{
		struct pollfd fds;
		unsigned nfds;
		kernel_ulong_t start, cur, end;

		start = tcp->u_arg[0];
		nfds = tcp->u_arg[1];

		if (nfds > 1024 * 1024)
			nfds = 1024 * 1024;
		end = start + sizeof(fds) * nfds;

		if (nfds == 0 || end < start)
			return false;

		for (cur = start; cur < end; cur += sizeof(fds)) {
			if (umove(tcp, cur, &fds))
				break;
			if (fdmatch(tcp, fds.fd, set))
				return true;
		}

		return false;
	}

	case SEN_fsconfig: {
		/* x, x, x, maybe path, maybe fd */
		const unsigned int cmd = tcp->u_arg[1];
		switch (cmd) {
			case 3 /* FSCONFIG_SET_PATH */:
			case 4 /* FSCONFIG_SET_PATH_EMPTY */:
				return fdmatch(tcp, tcp->u_arg[4], set) ||
					upathmatch(tcp, tcp->u_arg[3], set);
			case 5 /* FSCONFIG_SET_FD */:
				return fdmatch(tcp, tcp->u_arg[4], set);
		}

		return false;
	}

	case SEN_accept4:
	case SEN_accept:
	case SEN_bpf:
	case SEN_epoll_create:
	case SEN_epoll_create1:
	case SEN_eventfd2:
	case SEN_eventfd:
	case SEN_fanotify_init:
	case SEN_fsmount:
	case SEN_fsopen:
	case SEN_inotify_init:
	case SEN_inotify_init1:
	case SEN_io_uring_enter:
	case SEN_io_uring_register:
	case SEN_io_uring_setup:
	case SEN_memfd_create:
	case SEN_mq_getsetattr:
	case SEN_mq_notify:
	case SEN_mq_open:
	case SEN_mq_timedreceive_time32:
	case SEN_mq_timedreceive_time64:
	case SEN_mq_timedsend_time32:
	case SEN_mq_timedsend_time64:
	case SEN_perf_event_open:
	case SEN_pidfd_open:
	case SEN_pipe:
	case SEN_pipe2:
	case SEN_printargs:
	case SEN_signalfd4:
	case SEN_signalfd:
	case SEN_socket:
	case SEN_socketpair:
	case SEN_timerfd_create:
	case SEN_timerfd_gettime32:
	case SEN_timerfd_gettime64:
	case SEN_timerfd_settime32:
	case SEN_timerfd_settime64:
	case SEN_userfaultfd:
		/*
		 * These have TRACE_FILE or TRACE_DESCRIPTOR or TRACE_NETWORK set,
		 * but they don't have any file descriptor or path args to test.
		 */
		return false;
	}

	/*
	 * Our fallback position for calls that haven't already
	 * been handled is to just check arg[0].
	 */

	if (s->sys_flags & TRACE_FILE)
		return upathmatch(tcp, tcp->u_arg[0], set);

	if (s->sys_flags & (TRACE_DESC | TRACE_NETWORK))
		return fdmatch(tcp, tcp->u_arg[0], set);

	return false;
}
