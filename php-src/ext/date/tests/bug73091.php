<?php
class foo {
    function __toString() {
        var_dump(0);
        return 'may be a bug';
    }
}

var_dump(unserialize('O:12:"DateInterval":1:{s:4:"days";O:3:"foo":0:{}}'));
?>
