<?php
$phar = new Phar(__FILE__);
$d = dirname(__FILE__) . "/copyonwrite6";
mkdir($d);
file_put_contents($d . "/file1", "file1\n");
file_put_contents($d . "/file2", "file2\n");
$arr = $phar->buildFromIterator(new RecursiveDirectoryIterator($d, RecursiveDirectoryIterator::SKIP_DOTS),$d);
$arr = $phar->buildFromDirectory($d);
ksort($arr);
var_dump($arr);
$phar2 = new Phar(__FILE__);
$arr = array();
foreach ($phar2 as $name => $file) {
	$arr[$name] = $file->getContent();
}
ksort($arr);
foreach ($arr as $name => $content) {
	echo $name, " ", $content;
}
echo "ok\n";
__HALT_COMPILER(); ?>
r                     hi   [�wb   zzo��         file1   [�wb   �)�         file2   [�wb   Ǥɶ      hi
file1
file2
{=�������4��;	��"   GBMB