<?php
$array = ['key' => 'value'];

$ref = &$array['key'];

unset($ref);

extract($array);

$key = "bad";

var_dump($array);
?>
