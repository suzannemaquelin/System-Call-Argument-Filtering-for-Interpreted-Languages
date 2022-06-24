<?php

$src = dirname(__FILE__) . DIRECTORY_SEPARATOR . "67647.mov";

$f_base = "67647私はガラスを食べられます.mov";
$f = dirname(__FILE__) . DIRECTORY_SEPARATOR . $f_base;

/* Streams mb path support is tested a lot elsewhere. Copy the existing file
	therefore, avoid duplication in the repo. */
if (!copy($src, $f) || empty(glob($f))) {
	die("failed to copy '$src' to '$f'");
}

$fi = new finfo(FILEINFO_MIME_TYPE);
var_dump($fi->file($f));

?>
+++DONE+++
