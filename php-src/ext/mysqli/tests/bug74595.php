<?php
$class = new ReflectionClass('mysqli');
$method = $class->getMethod('query');
var_dump($method->getParameters());
?>
