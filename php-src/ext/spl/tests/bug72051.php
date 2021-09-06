<?php

$data = [
	[1,2]
];

$callbackTest = new CallbackFilterIterator(new ArrayIterator($data), function (&$current) {
	$current['message'] = 'Test message';
	return true;
});

$callbackTest->rewind();
$data = $callbackTest->current();
$callbackTest->next();
print_r($data);
?>
