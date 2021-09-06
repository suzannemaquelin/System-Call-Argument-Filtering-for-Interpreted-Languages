<?php

class MyFixedArray extends \SplFixedArray
{
    public function offsetExists($name) {
        echo "offsetExists($name)\n";
        return parent::offsetExists($name);
    }
    public function offsetGet($name) {
        echo "offsetGet($name)\n";
        return parent::offsetGet($name);
    }
    public function offsetSet($name, $value) {
        echo "offsetSet($name)\n";
        return parent::offsetSet($name, $value);
    }
    public function offsetUnset($name) {
        echo "offsetUnset($name)\n";
        return parent::offsetUnset($name);
    }

};

$fixedData = new MyFixedArray(10);
var_dump(isset($fixedData[0][1][2]));
var_dump(isset($fixedData[0]->foo));
var_dump($fixedData[0] ?? 42);
var_dump($fixedData[0][1][2] ?? 42);

$fixedData[0] = new MyFixedArray(10);
$fixedData[0][1] = new MyFixedArray(10);
var_dump(isset($fixedData[0][1][2]));
var_dump($fixedData[0][1][2] ?? 42);

?>
