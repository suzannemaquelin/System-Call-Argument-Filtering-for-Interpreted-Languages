<?php
$foo = "okey";
$foo_reference =& $foo;

$array = compact('foo_reference');

$foo = 'changed!';

var_dump($array['foo_reference']);
