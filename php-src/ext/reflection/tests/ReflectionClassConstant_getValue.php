<?php

/* Use separate classes to make sure that in-place constant updates don't interfere */
class A {
    const X = self::Y * 2;
    const Y = 1;
}
class B {
    const X = self::Y * 2;
    const Y = 1;
}
class C {
    const X = self::Y * 2;
    const Y = 1;
}

var_dump((new ReflectionClassConstant('A', 'X'))->getValue());
echo new ReflectionClassConstant('B', 'X');
echo new ReflectionClass('C');

?>
