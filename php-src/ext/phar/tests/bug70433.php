<?php
$phar = new PharData(__DIR__."/bug70433.zip");
var_dump($phar);
$meta = $phar->getMetadata();
var_dump($meta);
?>
DONE
