<?php

$magic_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'magic私はガラスを食べられます';

$ret = @finfo_open(FILEINFO_NONE, $magic_file . ".non-exits私はガラスを食べられます");
var_dump($ret);

$dir = __DIR__ . "/test-folder";
@mkdir($dir);

$magic_file_copy = $dir . "/magic私はガラスを食べられます.copy";
$magic_file_copy2 = $magic_file_copy . "2";
copy($magic_file, $magic_file_copy);
copy($magic_file, $magic_file_copy2);

$ret = finfo_open(FILEINFO_NONE, $dir);
var_dump($ret);

$ret = @finfo_open(FILEINFO_NONE, $dir);
var_dump($ret);

$ret = @finfo_open(FILEINFO_NONE, $dir. "/non-exits-dir私はガラスを食べられます");
var_dump($ret);

// write some test files to test folder
file_put_contents($dir . "/test1.txt", "string\n> Core\n> Me");
file_put_contents($dir . "/test2.txt", "a\nb\n");
@mkdir($dir . "/test-inner-folder私はガラスを食べられます");

finfo_open(FILEINFO_NONE, $dir);
echo "DONE: testing dir with files\n";

rmdir($dir . "/test-inner-folder私はガラスを食べられます");
unlink($dir . "/test1.txt");
unlink($dir . "/test2.txt");

unlink($magic_file_copy);
unlink($magic_file_copy2);
rmdir($dir);
?>
===DONE===
