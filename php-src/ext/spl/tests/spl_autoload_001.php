<?php

echo "===EMPTY===\n";

var_dump(spl_autoload_extensions());

spl_autoload("TestClass");
if (!class_exists("TestClass")) {
    echo "Class TestClass could not be loaded\n";
}

$test_exts = array(NULL, "1", ".inc,,.php.inc", "");

foreach($test_exts as $exts) {
	echo "===($exts)===\n";
    spl_autoload("TestClass", $exts);
    if (!class_exists("TestClass")) {
        echo "Class TestClass could not be loaded\n";
    }
}

spl_autoload_extensions(".inc,.php.inc");
spl_autoload("TestClass");
if (!class_exists("TestClass")) {
    echo "Class TestClass could not be loaded\n";
}

function TestFunc1($classname)
{
	echo __METHOD__ . "($classname)\n";
}

function TestFunc2($classname)
{
	echo __METHOD__ . "($classname)\n";
}

echo "===SPL_AUTOLOAD()===\n";

spl_autoload_register();

var_dump(spl_autoload_extensions(".inc"));
var_dump(class_exists("TestClass", true));

echo "===REGISTER===\n";

spl_autoload_unregister("spl_autoload");
spl_autoload_register("TestFunc1");
spl_autoload_register("TestFunc2");
spl_autoload_register("TestFunc2"); /* 2nd call ignored */
spl_autoload_extensions(".inc,.class.inc"); /* we do not have spl_autoload_registered yet */

var_dump(class_exists("TestClass", true));

echo "===LOAD===\n";

spl_autoload_register("spl_autoload");
var_dump(class_exists("TestClass", true));

echo "===NOFUNCTION===\n";

try
{
	spl_autoload_register("unavailable_autoload_function");
}
catch(Exception $e)
{
	echo 'Exception: ' . $e->getMessage() . "\n";
}

?>
===DONE===
