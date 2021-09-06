<?php
$doc = new DOMDocument();
for( $i=0; $i<20; $i++ ) {
	$doc->loadXML("<parent><child /><child /></parent>");
	$xpath = new DOMXpath($doc);
	$all = $xpath->query('//*');
	$doc->firstChild->nodeValue = '';
}
echo 'DONE', PHP_EOL;
?>
