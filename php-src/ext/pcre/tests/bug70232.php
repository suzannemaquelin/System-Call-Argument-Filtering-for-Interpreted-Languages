<?php
$pattern = '~(?: |\G)\d\B\K~';
$subject = "123 a123 1234567 b123 123";
preg_match_all($pattern, $subject, $matches);
var_dump($matches);
var_dump(preg_replace($pattern, "*", $subject));
var_dump(preg_split($pattern, $subject));
?>
