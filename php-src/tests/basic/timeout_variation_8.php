<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . "timeout_config.inc";

set_time_limit($t);

foreach (range(0, 42) as $i) {
	busy_wait(1);
}

?>
never reached here
