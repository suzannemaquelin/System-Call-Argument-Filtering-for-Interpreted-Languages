<?php

class Object {
	public function __construct() {
	}
}

$class= new ReflectionClass('Object');
var_dump($class->newInstanceArgs());

class Object1 {
	public function __construct($var) {
		var_dump($var);
	}
}

$class= new ReflectionClass('Object1');
try {
	var_dump($class->newInstanceArgs());
} catch (Throwable $e) {
	echo "Exception: " . $e->getMessage() . "\n";
}
var_dump($class->newInstanceArgs(array('test')));


echo "Done\n";
?>
