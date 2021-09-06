<?php

var_dump(json_last_error_msg());
var_dump(json_last_error_msg(true));
var_dump(json_last_error_msg('some', 4, 'args', 'here'));

?>
