<?php
$arr = array('a'=>'b');
echo 'Before -> '.current($arr).PHP_EOL;
array_walk_recursive($arr, function(&$val){});
echo 'After -> '.current($arr);
?>
