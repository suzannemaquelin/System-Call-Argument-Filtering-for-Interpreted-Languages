<?php
// In maintainer zts mode, this should no longer
// detect memory leaks for the objects
$a = new stdClass();
$b = new stdClass();
$map = new SplObjectStorage();
$map[$a] = 'foo';
var_dump($map[$b] ?? null);
var_dump($map[$a] ?? null);
