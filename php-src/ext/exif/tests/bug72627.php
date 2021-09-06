<?php
	$exif = exif_read_data(__DIR__ . '/bug72627.tiff',0,0,true);
	var_dump($exif);
?>
