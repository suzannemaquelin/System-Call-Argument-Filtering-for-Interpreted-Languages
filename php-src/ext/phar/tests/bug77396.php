<?php
$path = '../' . str_repeat("x", PHP_MAXPATHLEN) . '.tar';
$phar = new PharData($path);
?>
