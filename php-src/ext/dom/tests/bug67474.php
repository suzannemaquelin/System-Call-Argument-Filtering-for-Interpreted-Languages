<?php
$doc = new DOMDocument();
$doc->loadXML('<root xmlns:x="x"><a/><x:a/></root>');
$list = $doc->getElementsByTagNameNS('', 'a');
var_dump($list->length);
$list = $doc->getElementsByTagNameNS(null, 'a');
var_dump($list->length);
?>
