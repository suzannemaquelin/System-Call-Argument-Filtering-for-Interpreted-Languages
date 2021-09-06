<?php
$width = $height = 42;
$s = exif_thumbnail(__DIR__."/bug77540.jpg", $width, $height);
echo "Width ".$width."\n";
echo "Height ".$height."\n";
?>
DONE
