<?php
class A {
	public const publicConst = 'publicConst';
	static function staticConstDump() {
		var_dump(self::publicConst);
	}
	function constDump() {
		var_dump(self::publicConst);
	}
}

var_dump(A::publicConst);
A::staticConstDump();
(new A())->constDump();

?>
