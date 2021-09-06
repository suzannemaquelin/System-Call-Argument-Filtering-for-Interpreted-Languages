<?php
$arr = [1,3,55,66,43,6];

$iter = new NoRewindIterator(new ArrayIterator($arr));

while($iter->valid()) {
	    $iter->next();
}

var_dump($iter->current());
?>
