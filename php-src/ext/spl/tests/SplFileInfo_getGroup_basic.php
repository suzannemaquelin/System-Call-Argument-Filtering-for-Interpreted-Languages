<?php
$filename = __DIR__ . "/SplFileInfo_getGroup_basic";
touch($filename);
$fileInfo = new SplFileInfo($filename);
$expected = filegroup($filename);
$actual = $fileInfo->getGroup();
var_dump($expected == $actual);
?>
