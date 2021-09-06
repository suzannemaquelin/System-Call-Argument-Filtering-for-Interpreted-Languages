<?php

require_once(__DIR__ . '/new_db.inc');

$func = 'strtoupper';
var_dump($db->createfunction($func, $func, 1, SQLITE3_DETERMINISTIC));
var_dump($db->querySingle('SELECT strtoupper("test")'));

$func2 = 'strtolower';
var_dump($db->createfunction($func2, $func2, 1, SQLITE3_DETERMINISTIC));
var_dump($db->querySingle('SELECT strtolower("TEST")'));

var_dump($db->createfunction($func, $func2, 1, SQLITE3_DETERMINISTIC));
var_dump($db->querySingle('SELECT strtoupper("tEst")'));


?>
