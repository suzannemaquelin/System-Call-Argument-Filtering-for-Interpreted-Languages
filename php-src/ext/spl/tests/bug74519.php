<?php

$iterator = new \AppendIterator();
$events = new \ArrayIterator([1,2,3,4,5]);
$iterator->append($events);

$events->next();

while($iterator->valid()) {
	echo $iterator->current(), "\n";
	$iterator->next();
}
?>
===DONE===
