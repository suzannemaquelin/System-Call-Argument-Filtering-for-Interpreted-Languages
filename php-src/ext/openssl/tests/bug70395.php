<?php
$func = new ReflectionFunction('openssl_seal');
$param = $func->getParameters()[4];
var_dump($param);
var_dump($param->isOptional());
?>
