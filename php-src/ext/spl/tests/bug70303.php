<?php
$f = new ReflectionClass('ArrayObject');
$c = $f->getConstructor();
$params = $c->getParameters();
$param = $params[0];
var_dump($param->isOptional());
?>
