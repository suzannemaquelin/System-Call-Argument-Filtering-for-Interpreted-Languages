<?php
chdir(__DIR__);
mkdir("test72321");
$phar = new PharData("72321_1.zip");
$phar->extractTo("test72321");
$phar = new PharData("72321_2.zip");
try {
$phar->extractTo("test72321");
} catch(PharException $e) {
	print $e->getMessage()."\n";
}
?>
DONE
