<?php
$buggy = new DateInterval('P0Y');
$buggy->f += 0.01;

$ok = new DateInterval('P0Y');
$ok->f = $ok->f + 0.01;

var_dump($buggy->f);
var_dump($ok->f);
?>
