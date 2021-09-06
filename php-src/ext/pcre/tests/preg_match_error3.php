<?php
var_dump(preg_match('/^(foo)+$/', str_repeat('foo', 1024*8192)));
var_dump(preg_last_error() === PREG_JIT_STACKLIMIT_ERROR);
?>
