<?php

$pattern = [];
for ($i = 0; $i < 300; $i++) {
    $pattern[] = "(?'group{$i}'{$i}$)";
}
$fullPattern = '/' . implode('|', $pattern) . '/uix';

preg_match($fullPattern, '290', $matches);

var_dump($matches['group290']);
?>
