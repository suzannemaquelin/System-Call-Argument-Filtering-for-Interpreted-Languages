<?php

set_error_handler(function() {
    throw new Exception();
});

class A
{
	public function method($test = PHP_SELF + 1)
	{
	}
}

$class = new ReflectionClass('A');

echo $class;
?>
