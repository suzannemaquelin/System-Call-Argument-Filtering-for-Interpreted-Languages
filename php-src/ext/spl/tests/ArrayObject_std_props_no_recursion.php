<?php

$a = new ArrayObject([1, 2, 3], ArrayObject::STD_PROP_LIST);
$a->prop = 'a';
$b = new ArrayObject($a, 0);
$b->prop = 'b';
var_dump((array) $b);
$c = new ArrayObject($a);
$c->prop = 'c';
var_dump((array) $c);

?>
