--TEST--
Phar object: basics
--SKIPIF--
<?php
if (!extension_loaded("phar")) die("skip");
if (version_compare(PHP_VERSION, "6.0", "!=")) die("skip Unicode support required");
if (!extension_loaded("spl")) die("skip SPL not available");
?>
--INI--
phar.require_hash=0
phar.readonly=0
--FILE--
<?php

require_once 'files/phar_oo_test.inc';

$phar = new Phar($fname);
var_dump($phar->getVersion());
var_dump(count($phar));

class MyPhar extends Phar
{
	function __construct()
	{
	}
}

try
{
	$phar = new MyPhar();
	var_dump($phar->getVersion());
}
catch (BadMethodCallException $e)
{
	var_dump($e->getMessage());
}
try {
	$phar = new Phar('test.phar');
	$phar->__construct('oops');
} catch (BadMethodCallException $e)
{
	var_dump($e->getMessage());
}

?>
===DONE===
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/files/phar_oo_001U.phar.php');
__halt_compiler();
?>
--EXPECT--
string(5) "1.0.0"
int(5)
unicode(50) "Cannot call method on an uninitialized Phar object"
unicode(29) "Cannot call constructor twice"
===DONE===
