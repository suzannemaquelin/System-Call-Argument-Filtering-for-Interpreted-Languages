<?php
chdir(__DIR__);
try {
$phar = new PharData('bug72928.zip');
var_dump($phar);
} catch(UnexpectedValueException $e) {
	print $e->getMessage()."\n";
}
?>
DONE
