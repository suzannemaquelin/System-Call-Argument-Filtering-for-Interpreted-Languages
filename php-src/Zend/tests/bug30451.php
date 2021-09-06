<?php

class A {

	protected static $property = TRUE;

	protected static function method() {
		return TRUE;
	}

}

class B extends A {

	public function __construct() {

		var_dump(self::method());
		var_dump(parent::method());

		var_dump(self::$property);
		var_dump(parent::$property);

	}

}

new B;
?>
