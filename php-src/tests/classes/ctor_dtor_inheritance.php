<?php

// This test checks for:
// - inherited constructors/destructors are not called automatically
// - base classes know about derived properties in constructor/destructor
// - base class constructors/destructors know the instanciated class name

class base {
	public $name;

	function __construct() {
		echo __CLASS__ . "::" . __FUNCTION__ . "\n";
		$this->name = 'base';
		print_r($this);
	}

	function __destruct() {
		echo __CLASS__ . "::" . __FUNCTION__ . "\n";
		print_r($this);
	}
}

class derived extends base {
	public $other;

	function __construct() {
		$this->name = 'init';
		$this->other = 'other';
		print_r($this);
		parent::__construct();
		echo __CLASS__ . "::" . __FUNCTION__ . "\n";
		$this->name = 'derived';
		print_r($this);
	}

	function __destruct() {
		parent::__destruct();
		echo __CLASS__ . "::" . __FUNCTION__ . "\n";
		print_r($this);
	}
}

echo "Testing class base\n";
$t = new base();
unset($t);
echo "Testing class derived\n";
$t = new derived();
unset($t);

echo "Done\n";
?>
