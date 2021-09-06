<?php
	$finfo = finfo_open(FILEINFO_NONE, dirname(__FILE__) . DIRECTORY_SEPARATOR . "bug71527.magic");
	$info = finfo_file($finfo, __FILE__);
	var_dump($info);
?>
