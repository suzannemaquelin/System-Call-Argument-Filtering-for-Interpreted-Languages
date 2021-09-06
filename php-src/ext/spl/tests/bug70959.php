<?php
class testObject extends ArrayObject {
	protected $test;

	public function getTest() {
		return $this->test;
	}

	public function setTest($test) {
		$this->test = $test;
	}
}

$obj = new testObject();
$obj->setTest('test');
var_dump($obj->getTest());
$obj2 = unserialize(serialize($obj));
var_dump($obj2->getTest());
