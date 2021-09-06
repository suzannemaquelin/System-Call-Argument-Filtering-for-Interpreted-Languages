<?php
$b = 666;
var_dump($b);
$c = &$b;
$var5 = pcntl_wait($b,0,$c);
unset($b);

$b = 666;
var_dump($b);
$c = &$b;
$var5 = pcntl_waitpid(0,$b,0,$c);
unset($b);
?>
