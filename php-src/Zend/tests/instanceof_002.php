<?php

interface ITest {
}

interface IFoo extends ITest {
}

class foo extends stdClass implements ITest {
}

var_dump(new foo instanceof stdClass);
var_dump(new foo instanceof ITest);
var_dump(new foo instanceof IFoo);

class bar extends foo implements IFoo {
}

var_dump(new bar instanceof stdClass);
var_dump(new bar instanceof ITest);
var_dump(new bar instanceof IFoo);

?>
