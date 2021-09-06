<?php

ini_set('unserialize_callback_func', 'evil');

function evil() {
	function __autoload($arg) {
        var_dump(unserialize('R:1;'));
    }
}

var_dump(unserialize('a:2:{i:0;i:42;i:1;O:4:"evil":0:{}}'));

?>
