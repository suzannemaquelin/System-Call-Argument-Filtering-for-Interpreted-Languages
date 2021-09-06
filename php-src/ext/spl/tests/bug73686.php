<?php

$ao = new ArrayObject;

foreach ([1, 2, 3] as $i => $var)
{
	settype($var, 'string');
	$ao[$i] = $var;
}
var_dump($ao);

$ao = new ArrayObject;

foreach ([1, 2, 3] as $i => $var)
{
	$ao[$i] = &$var;
}
var_dump($ao);
?>
