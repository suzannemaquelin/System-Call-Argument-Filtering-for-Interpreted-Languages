<?php
$doc = new DOMDocument();
$doc->loadXML('<example a="b">Test</example>');

$example = $doc->getElementsByTagName('example')->item(0);
$attr    = $example->getAttributeNode('a');

var_dump($attr);
print_r($attr);
