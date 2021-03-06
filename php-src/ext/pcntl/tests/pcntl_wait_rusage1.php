<?php
$pid = pcntl_fork();
if ($pid == -1) {
	die("failed");
} else if ($pid) {
	$status = 0;
	var_dump(pcntl_wait($status, WUNTRACED, $rusage));
	var_dump($rusage['ru_utime.tv_sec']);
	var_dump($rusage['ru_utime.tv_usec']);

	posix_kill($pid, SIGCONT);

	$rusage = array(1,2,3);
	pcntl_wait($status, WUNTRACED, $rusage);
	var_dump($rusage['ru_utime.tv_sec']);
	var_dump($rusage['ru_utime.tv_usec']);

	$rusage = "string";
	pcntl_wait($status, 0, $rusage);
	var_dump(gettype($rusage));
	var_dump(count($rusage));

	$rusage = new stdClass;
	pcntl_wait($status, 0, $rusage);
	var_dump(gettype($rusage));
	var_dump(count($rusage));

	echo "END\n";
} else {
	posix_kill(posix_getpid(), SIGSTOP);
	exit(42);
}
?>
