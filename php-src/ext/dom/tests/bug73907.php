<?php
$xmlString = '<?xml version="1.0" encoding="utf-8" ?>
<root>
</root>';

$doc = new DOMDocument();
$doc->loadXML($xmlString);
$attr = $doc->documentElement;

var_dump($attr);
