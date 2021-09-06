<?php

$xml = new SimpleXMLElement('<root><elem>Text</elem></root>');

echo 'elem2 is: ' . ($xml->elem2 ?? 'backup string') . "\n";
echo 'elem2 is: ' . (isset($xml->elem2) ? $xml->elem2 : 'backup string') . "\n";

?>
