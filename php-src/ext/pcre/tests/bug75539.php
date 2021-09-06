<?php

var_dump(preg_match('/((?1)?z)/', ''));
var_dump(preg_last_error() === \PREG_INTERNAL_ERROR);

?>
