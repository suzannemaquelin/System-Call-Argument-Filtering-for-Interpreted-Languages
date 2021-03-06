<?php

$pid = pcntl_fork();
if ($pid == -1) {
	die('failed');
} else if ($pid) {
	pcntl_sigprocmask(SIG_BLOCK, array(SIGCHLD,(string)SIGTERM));
	$oldset = array();
	pcntl_sigprocmask(SIG_BLOCK, array(), $oldset);
	var_dump(in_array(SIGCHLD, $oldset));
	var_dump(in_array(SIGTERM, $oldset));

	posix_kill(posix_getpid(), SIGTERM);
	$signo = pcntl_sigwaitinfo(array(SIGTERM), $siginfo);
	echo "signo == SIGTERM\n";
	var_dump($signo === SIGTERM && $signo === $siginfo['signo']);
	echo "code === SI_USER || SI_NOINFO\n";
	if (defined('SI_NOINFO')) {
		var_dump(($siginfo['code'] === SI_USER) || ($siginfo['code'] === SI_NOINFO));
	} else {
		var_dump($siginfo['code'] === SI_USER);
	}

	pcntl_signal(SIGCHLD, function($signo){});
	posix_kill($pid, SIGTERM);
	$signo = pcntl_sigwaitinfo(array((string)SIGCHLD), $siginfo);
	echo "signo == SIGCHLD\n";
	var_dump($signo === SIGCHLD && $signo === $siginfo['signo']);
	echo "code === CLD_KILLED\n";
	var_dump($siginfo['code'] === CLD_KILLED);
	echo "signo === SIGCHLD\n";
	var_dump($siginfo['signo'] === SIGCHLD);
	echo "signo === uid\n";
	var_dump($siginfo['uid'] === posix_getuid());
	echo "signo === pid\n";
	var_dump($siginfo['pid'] === $pid);
	pcntl_waitpid($pid, $status);

	set_error_handler(function($errno, $errstr) { echo "Error triggered\n"; }, E_WARNING);

	echo "sigprocmask with invalid arguments\n";

	/* Valgrind expectedly complains about this:
         * "sigprocmask: unknown 'how' field 2147483647"
	 * Skip */
	if (getenv("USE_ZEND_ALLOC") !== '0') {
		var_dump(pcntl_sigprocmask(PHP_INT_MAX, array(SIGTERM)));
	} else {
		echo "Error triggered\n";
		echo "bool(false)\n";
	}
	var_dump(pcntl_sigprocmask(SIG_SETMASK, array(0)));

	echo "sigwaitinfo with invalid arguments\n";
	var_dump(pcntl_sigwaitinfo(array(0)));

	echo "sigtimedwait with invalid arguments\n";
	var_dump(pcntl_sigtimedwait(array(SIGTERM), $signo, PHP_INT_MAX, PHP_INT_MAX));
} else {
	$siginfo = NULL;
	pcntl_sigtimedwait(array(SIGINT), $siginfo, 3600, 0);
	exit;
}

?>
