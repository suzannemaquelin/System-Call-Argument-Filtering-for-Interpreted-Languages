<?php
chdir(__DIR__);
try {
$phar = new PharData('bug73035.tar');
var_dump($phar);
} catch(UnexpectedValueException $e) {
	print $e->getMessage()."\n";
}
?>
DONE
