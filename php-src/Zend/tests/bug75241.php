<?php
function eh(){}

set_error_handler('eh');

$d->d = &$d + $d->d/=0;
var_dump($d);
?>
