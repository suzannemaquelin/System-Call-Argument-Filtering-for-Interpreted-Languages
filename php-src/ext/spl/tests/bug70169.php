<?php
$inner = 'i:1;';
$exploit = 'a:2:{i:0;C:19:"SplDoublyLinkedList":'.strlen($inner).':{'.$inner.'}i:1;R:3;}';

$data = unserialize($exploit);

for($i = 0; $i < 5; $i++) {
    $v[$i] = 'hi'.$i;
}

var_dump($data);
?>
===DONE===
