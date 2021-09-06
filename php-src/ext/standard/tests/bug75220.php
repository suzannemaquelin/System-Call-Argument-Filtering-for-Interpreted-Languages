<?php

$a = new A();
$a->bar('foo');

class B {};
class A extends B
{
	function bar($func)
	{
		var_dump('foo');
		var_dump(is_callable('parent::foo'));
		var_dump(is_callable(array('parent', 'foo')));
	}

	function __call($func, $args)
	{
	}
};

?>
