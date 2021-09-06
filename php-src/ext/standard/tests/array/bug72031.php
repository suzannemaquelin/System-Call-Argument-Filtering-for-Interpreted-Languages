<?php

class myObj {
    public $prop;
    public function __construct($prop) {
        $this->prop = $prop;
    }
}

$objects = [
    new myObj(-1),
    new myObj(0),
    new myObj(1),
    new myObj(2),
    new myObj(null),
    new myObj(true),
    new myObj(false),
    new myObj('abc'),
    new myObj(''),
];

var_dump(array_column($objects, 'prop'));

?>
