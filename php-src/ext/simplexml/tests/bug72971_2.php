<?php

$xml = new SimpleXMLElement('<root xmlns:ns="ns"><foo>bar</foo><ns:foo>ns:bar</ns:foo></root>');

$xml->foo = 'new-bar';
var_dump($xml->foo);
var_dump($xml->children('ns')->foo);

$xml->children('ns')->foo = 'ns:new-bar';
var_dump($xml->foo);
var_dump($xml->children('ns')->foo);

?>
