<?php

new class {
    function __construct() {
        $fname = null;
        if (is_callable([$this, 'f'], false, $fname)) {
            call_user_func($fname);
        } else {
            echo "dang\n";
        }
    }
    function f() {
        echo "nice\n";
    }
};

?>
