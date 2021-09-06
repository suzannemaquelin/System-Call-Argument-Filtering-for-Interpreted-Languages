<?php

$arrayIterator = new ArrayIterator(array('key 1' => 'value 1', 'key 2' => ['value 2']));
$regexIterator = new RegexIterator($arrayIterator, '/^key/', RegexIterator::MATCH, RegexIterator::USE_KEY);

foreach ($regexIterator as $key => $value) {
    var_dump($key, $value);
}

?>
