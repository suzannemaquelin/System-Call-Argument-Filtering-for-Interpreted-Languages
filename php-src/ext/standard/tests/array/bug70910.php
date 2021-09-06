<?php
$var = 'original value';
$ref =& $var;

$hash = ['var' => 'new value'];

extract($hash);
var_dump($var === $ref);
