<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . "timeout_config.inc";

set_time_limit($t);

for ($i = 0; $i < 42; $i++) {
	busy_wait(1);
}

?>
never reached here
