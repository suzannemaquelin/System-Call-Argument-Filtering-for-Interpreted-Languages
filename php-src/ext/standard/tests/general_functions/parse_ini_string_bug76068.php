<?php

$s = parse_ini_string("[foo]\nbar=1|>baz",true, \INI_SCANNER_TYPED);
var_dump($s);

$s = parse_ini_string("[foo]\nbar=\"1|>baz\"",true, \INI_SCANNER_TYPED);
var_dump($s);

$s = parse_ini_string("[foo]\nbar=1",true, \INI_SCANNER_TYPED);
var_dump($s);

$s = parse_ini_string("[foo]\nbar=42|>baz",true, \INI_SCANNER_TYPED);
var_dump($s);

?>
==DONE==
