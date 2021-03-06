<?php
/* Prototype  : public mixed ReflectionFunction::getClosure()
 * Description: Returns a dynamically created closure for the function
 * Source code: ext/reflection/php_reflection.c
 * Alias to functions:
 */

echo "*** Testing ReflectionFunction::getClosure() : basic functionality ***\n";

function foo()
{
	var_dump( "Inside foo function" );
}

function bar( $arg )
{
	var_dump( "Arg is " . $arg );
}

$func = new ReflectionFunction( 'foo' );
$closure = $func->getClosure();
$closure();

$func = new ReflectionFunction( 'bar' );
$closure = $func->getClosure();
$closure( 'succeeded' );

?>
===DONE===
