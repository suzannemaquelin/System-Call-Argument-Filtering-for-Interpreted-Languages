<?php
$rc = new ReflectionClass(Phar::class);
$rm = $rc->getMethod("running");
echo $rm->getNumberOfParameters();
echo PHP_EOL;
echo $rm->getNumberOfRequiredParameters();
echo PHP_EOL;
echo (int) $rm->getParameters()[0]->isOptional();

?>
