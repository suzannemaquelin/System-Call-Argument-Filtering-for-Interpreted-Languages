<?php

class NewCtor {
    function __construct() {
        echo "In " . __METHOD__ . "\n";
    }

}
echo "New-style constructor:\n";
$methodInfo = new ReflectionMethod("NewCtor::__construct");
var_dump($methodInfo->isConstructor());

class ExtendsNewCtor extends NewCtor {
}
echo "\nInherited new-style constructor\n";
$methodInfo = new ReflectionMethod("ExtendsNewCtor::__construct");
var_dump($methodInfo->isConstructor());

class OldCtor {
    function OldCtor() {
        echo "In " . __METHOD__ . "\n";
    }
}
echo "\nOld-style constructor:\n";
$methodInfo = new ReflectionMethod("OldCtor::OldCtor");
var_dump($methodInfo->isConstructor());

class ExtendsOldCtor extends OldCtor {
}
echo "\nInherited old-style constructor:\n";
$methodInfo = new ReflectionMethod("ExtendsOldCtor::OldCtor");
var_dump($methodInfo->isConstructor());

class X {
    function Y() {
        echo "In " . __METHOD__ . "\n";
    }
}
echo "\nNot a constructor:\n";
$methodInfo = new ReflectionMethod("X::Y");
var_dump($methodInfo->isConstructor());

class Y extends X {
}
echo "\nInherited method of the same name as the class:\n";
$methodInfo = new ReflectionMethod("Y::Y");
var_dump($methodInfo->isConstructor());

class OldAndNewCtor {
    function OldAndNewCtor() {
        echo "In " . __METHOD__ . "\n";
    }

    function __construct() {
        echo "In " . __METHOD__ . "\n";
    }
}
echo "\nOld-style constructor:\n";
$methodInfo = new ReflectionMethod("OldAndNewCtor::OldAndNewCtor");
var_dump($methodInfo->isConstructor());

echo "\nRedefined constructor:\n";
$methodInfo = new ReflectionMethod("OldAndNewCtor::__construct");
var_dump($methodInfo->isConstructor());

class NewAndOldCtor {
    function __construct() {
        echo "In " . __METHOD__ . "\n";
    }

    function NewAndOldCtor() {
        echo "In " . __METHOD__ . "\n";
    }
}
echo "\nNew-style constructor:\n";
$methodInfo = new ReflectionMethod("NewAndOldCtor::__construct");
var_dump($methodInfo->isConstructor());

echo "\nRedefined old-style constructor:\n";
$methodInfo = new ReflectionMethod("NewAndOldCtor::NewAndOldCtor");
var_dump($methodInfo->isConstructor());

?>
