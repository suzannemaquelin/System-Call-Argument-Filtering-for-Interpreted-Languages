<?php
	$exif = exif_thumbnail(__DIR__ . '/bug73737.tiff');
	var_dump($exif);
?>
