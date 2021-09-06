<?php
class Foo {
	private const C1 = "a";
}

try {
	var_dump(constant('Foo::C1'));
} catch (Error $e) {
	var_dump($e->getMessage());
}
