<?php

class Foo extends ArrayIterator { }

$r = new ReflectionClass(Foo::class);
var_dump($r->getConstants());
$r = new ReflectionClass(ArrayIterator::class);
var_dump($r->getConstants());
$r = new ReflectionClass(RecursiveArrayIterator::class);
var_dump($r->getConstants());

?>
