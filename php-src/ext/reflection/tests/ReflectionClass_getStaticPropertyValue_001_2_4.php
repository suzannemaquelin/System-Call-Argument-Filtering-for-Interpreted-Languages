<?php
class A {
	static private $privateOverridden = "original private";
	static protected $protectedOverridden = "original protected";
	static public $publicOverridden = "original public";
}

class B extends A {
	static private $privateOverridden = "changed private";
	static protected $protectedOverridden = "changed protected";
	static public $publicOverridden = "changed public";
}

echo "Retrieving static values from A:\n";
$rcA = new ReflectionClass('A');
var_dump($rcA->getStaticPropertyValue("privateOverridden", "default value"));
var_dump($rcA->getStaticPropertyValue("\0A\0privateOverridden"));
var_dump($rcA->getStaticPropertyValue("protectedOverridden", "default value"));
var_dump($rcA->getStaticPropertyValue("\0*\0protectedOverridden"));
var_dump($rcA->getStaticPropertyValue("publicOverridden"));

echo "\nRetrieving static values from B:\n";
$rcB = new ReflectionClass('B');
var_dump($rcB->getStaticPropertyValue("\0A\0privateOverridden"));
var_dump($rcB->getStaticPropertyValue("\0B\0privateOverridden"));
var_dump($rcB->getStaticPropertyValue("\0*\0protectedOverridden"));
var_dump($rcB->getStaticPropertyValue("publicOverridden"));

echo "\nRetrieving non-existent values from A with no default value:\n";
try {
	var_dump($rcA->getStaticPropertyValue("protectedOverridden"));
	echo "you should not see this";
} catch (Exception $e) {
	echo $e->getMessage() . "\n";
}

try {
	var_dump($rcA->getStaticPropertyValue("privateOverridden"));
	echo "you should not see this";
} catch (Exception $e) {
	echo $e->getMessage() . "\n";
}

?>
