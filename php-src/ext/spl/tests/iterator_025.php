<?php

class MyRecursiveIteratorIterator extends RecursiveIteratorIterator
{
	function beginIteration()
	{
		echo __METHOD__ . "()\n";
	}

	function endIteration()
	{
		echo __METHOD__ . "()\n";
	}
}

$ar = array(1, 2, array(31, 32, array(331)), 4);

$it = new MyRecursiveIteratorIterator(new ArrayObject($ar, 0, "RecursiveArrayIterator"));

foreach($it as $v) echo "$v\n";

echo "===MORE===\n";

foreach($it as $v) echo "$v\n";

echo "===MORE===\n";

$it->rewind();
foreach($it as $v) echo "$v\n";
var_dump($it->valid());

echo "===MANUAL===\n";

$it->rewind();
while($it->valid())
{
	echo $it->current() . "\n";
	$it->next();
	break;
}
$it->rewind();
while($it->valid())
{
	echo $it->current() . "\n";
	$it->next();
}

?>
===DONE===
