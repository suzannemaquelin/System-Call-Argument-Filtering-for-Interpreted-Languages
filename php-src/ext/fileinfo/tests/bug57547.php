<?php

$filenames = array("..", __FILE__);

foreach ($filenames as $filename) {
	$finfo = new finfo(FILEINFO_MIME);
	var_dump($finfo->file($filename));

	$finfo2 = new finfo();
	var_dump($finfo2->file($filename, FILEINFO_MIME));
}

?>
===DONE===
