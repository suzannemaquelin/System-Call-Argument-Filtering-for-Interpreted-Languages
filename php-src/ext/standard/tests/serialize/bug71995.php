<?php

class A {
	public $b;
	public function __construct() {
		$this->b = new StdClass();
	}
	public  function __sleep() {
		return array("b", "b");
	}
}
$a = new A();
$s = serialize($a);
var_dump($s);
var_dump(unserialize($s));
?>
