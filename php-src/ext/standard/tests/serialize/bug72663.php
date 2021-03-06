<?php

class Test1 {
    public function __wakeup() {
        echo "Wakeup\n";
    }
    public function __destruct() {
        echo "Dtor\n";
    }
}

class Test2 {
    public function __wakeup() {
        throw new Exception('Unserialization forbidden');
    }
    public function __destruct() {
        echo "Dtor\n";
    }
}

// Unserialize object with error in properties
$s = 'O:5:"Test1":1:{s:10:"";}';
var_dump(unserialize($s));

// Variation: Object is turned into a reference
$s = 'O:5:"Test1":2:{i:0;R:1;s:10:"";}';
var_dump(unserialize($s));

// Unserialize object with throwing __wakeup
$s = 'O:5:"Test2":0:{}';
try {
    var_dump(unserialize($s));
} catch (Exception $e) {
    echo "Caught\n";
}
//
// Variation: Object is turned into a reference
$s = 'O:5:"Test2":1:{i:0;R:1;}';
try {
    var_dump(unserialize($s));
} catch (Exception $e) {
    echo "Caught\n";
}

?>
