<?php
$xml = <<<XML
<!DOCTYPE foo PUBLIC "-//FOO/BAR" "http://example.com/foobar">
<foo>bar</foo>
XML;

$dd = new DOMDocument;
$r = $dd->loadXML($xml);

var_dump(libxml_set_external_entity_loader([]));
var_dump(libxml_set_external_entity_loader());
var_dump(libxml_set_external_entity_loader(function() {}, 2));

var_dump(libxml_set_external_entity_loader(function($a, $b, $c, $d) {}));
try {
	var_dump($dd->validate());
} catch (Throwable $e) {
	echo "Exception: " . $e->getMessage() . "\n";
}

echo "Done.\n";
