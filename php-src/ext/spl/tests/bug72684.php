<?php

function createGenerator() { yield 1; }
$generator = createGenerator();

$appendIterator = new AppendIterator();
$appendIterator->append($generator);

iterator_to_array($appendIterator);
try {
	iterator_to_array($appendIterator);
} catch (\Exception $e) {
	echo $e->getMessage();
}

?>
