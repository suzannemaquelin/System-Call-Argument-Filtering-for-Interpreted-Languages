<?php

class Class1
{
	public $_Class2_obj;
}

class Class2
{
	public $storage = '';

	function __construct()
	{
		$this->storage = new Class1();

		$this->storage->_Class2_obj = $this;
	}
}

$foo = new Class2();

?>
Alive!
