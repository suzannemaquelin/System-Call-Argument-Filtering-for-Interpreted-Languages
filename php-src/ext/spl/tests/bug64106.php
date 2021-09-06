<?php

class MyFixedArray extends SplFixedArray {
    public function offsetGet($offset) { var_dump($offset); }
}

$array = new MyFixedArray(10);
$array[][1] = 10;

?>
