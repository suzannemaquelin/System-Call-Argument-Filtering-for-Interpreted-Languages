<?php
$fname = str_replace('\\', '/', dirname(__FILE__) . '/files/HTML_CSS-1.5.4.tgz');
try {
	$tar = new PharData($fname);
} catch(Exception $e) {
	echo $e->getMessage() . "\n";
}
?>
===DONE===
