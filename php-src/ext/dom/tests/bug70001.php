<?php
$element = new DOMText('<p>foo & bar</p>');
var_dump($element->textContent);
$element = (new DOMDocument())->createTextNode('<p>foo & bar</p>');
var_dump($element->textContent);
$element->textContent = ('<p>foo & bar</p>');
var_dump($element->textContent);
?>
