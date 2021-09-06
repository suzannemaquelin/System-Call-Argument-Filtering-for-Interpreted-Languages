<?php
class A {
	private const privateConst = 'privateConst';
	static function staticConstDump() {
		var_dump(self::privateConst);
	}
	function constDump() {
		var_dump(self::privateConst);
	}
}

A::staticConstDump();
(new A())->constDump();
constant('A::privateConst');

?>
