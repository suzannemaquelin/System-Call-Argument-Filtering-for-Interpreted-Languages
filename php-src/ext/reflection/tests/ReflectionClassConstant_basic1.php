<?php

function reflectClassConstant($base, $constant) {
    $constInfo = new ReflectionClassConstant($base, $constant);
    echo "**********************************\n";
    $class = is_object($base) ? get_class($base) : $base;
    echo "Reflecting on class constant $class::$constant\n\n";
    echo "__toString():\n";
    var_dump($constInfo->__toString());
    echo "export():\n";
    var_dump(ReflectionClassConstant::export($base, $constant, true));
    echo "export():\n";
    var_dump(ReflectionClassConstant::export($base, $constant, false));
    echo "getName():\n";
    var_dump($constInfo->getName());
    echo "getValue():\n";
    var_dump($constInfo->getValue());
    echo "isPublic():\n";
    var_dump($constInfo->isPublic());
    echo "isPrivate():\n";
    var_dump($constInfo->isPrivate());
    echo "isProtected():\n";
    var_dump($constInfo->isProtected());
    echo "getModifiers():\n";
    var_dump($constInfo->getModifiers());
    echo "getDeclaringClass():\n";
    var_dump($constInfo->getDeclaringClass());
    echo "getDocComment():\n";
    var_dump($constInfo->getDocComment());
    echo "\n**********************************\n";
}

class TestClass {
    public const /** My Doc comment */ PUB = true;
    /** Another doc comment */
    protected const PROT = 4;
    private const PRIV = "keepOut";
}
$instance = new TestClass();

reflectClassConstant("TestClass", "PUB");
reflectClassConstant("TestClass", "PROT");
reflectClassConstant("TestClass", "PRIV");
reflectClassConstant($instance, "PRIV");
reflectClassConstant($instance, "BAD_CONST");

?>
