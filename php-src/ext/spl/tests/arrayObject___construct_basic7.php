<?php
$y = 2;
$x = 1;
$a = array($y, $x);
$o = (object)$a;
$ao = new ArrayObject($o);
$ao->asort();
var_dump($a, $o, $ao);
?>
