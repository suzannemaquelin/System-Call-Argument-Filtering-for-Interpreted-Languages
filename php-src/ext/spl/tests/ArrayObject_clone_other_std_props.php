<?php

$a = new ArrayObject([1, 2, 3], ArrayObject::STD_PROP_LIST);
$b = new ArrayObject($a);
$c = clone $b;
var_dump($c);

?>
