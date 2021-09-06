<?php

$xml = new SimpleXMLElement('<root xmlns:ns="ns"><foo>bar</foo><ns:foo>ns:bar</ns:foo><ns:foo2>ns:bar2</ns:foo2></root>');
var_dump(isset($xml->foo2));
unset($xml->foo);
var_dump($xml->children('ns'));

?>
