<?php
var_dump(pcntl_signal_get_handler(SIGUSR1));

function pcntl_test($signo) {}
pcntl_signal(SIGUSR1, 'pcntl_test');
var_dump(pcntl_signal_get_handler(SIGUSR1));

pcntl_signal(SIGUSR1, SIG_DFL);
var_dump(pcntl_signal_get_handler(SIGUSR1));

pcntl_signal(SIGUSR1, SIG_IGN);
var_dump(pcntl_signal_get_handler(SIGUSR1));

posix_kill(posix_getpid(), SIGUSR1);
pcntl_signal_dispatch();

echo "ok\n";
?>
