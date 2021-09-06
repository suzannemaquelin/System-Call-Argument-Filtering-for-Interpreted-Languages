<?php
define('myerr', fopen('php://stderr', 'w'));
debug_zval_dump(myerr);
?>
