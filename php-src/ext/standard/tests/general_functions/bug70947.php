<?php
$o = parse_ini_string('foo = bar 123', FALSE, INI_SCANNER_TYPED);
var_dump($o);
?>
