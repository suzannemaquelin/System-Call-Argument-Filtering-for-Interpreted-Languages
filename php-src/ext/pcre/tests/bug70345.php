<?php
$regex = '/(?=xyz\K)/';
$subject = "aaaaxyzaaaa";

$v = preg_split($regex, $subject);
print_r($v);

$regex = '/(a(?=xyz\K))/';
$subject = "aaaaxyzaaaa";
preg_match($regex, $subject, $matches);

var_dump($matches);
