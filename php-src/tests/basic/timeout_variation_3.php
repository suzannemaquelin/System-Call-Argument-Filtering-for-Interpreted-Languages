<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . "timeout_config.inc";

set_time_limit($t);

function hello ($t) {
	echo "call", PHP_EOL;
	busy_wait($t*2);
}

eval('hello($t);');
?>
never reached here
