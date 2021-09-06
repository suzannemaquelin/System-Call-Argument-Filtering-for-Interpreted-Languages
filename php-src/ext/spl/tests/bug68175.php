<?php
$arr = new ArrayIterator(array());
$regex = new RegexIterator($arr, '/^test/');
var_dump(
    $regex->getMode(),
    $regex->getFlags(),
    $regex->getPregFlags()
);
?>
===DONE===
