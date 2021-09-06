<?php
$file = __DIR__ . '/.test';
touch($file);
$fileInfo = new SplFileInfo($file);

var_dump($fileInfo->getExtension());
unlink($file);
?>
