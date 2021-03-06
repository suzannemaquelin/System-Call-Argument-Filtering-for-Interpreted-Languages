<?php

$db = new SQLite3(':memory:');

$db->exec("CREATE TABLE test (a INTEGER, b TEXT, c REAL);" .
	    "INSERT INTO test VALUES (1, 'hello', 3.14);" .
	    "INSERT INTO test VALUES (3, 'world', 3.15);" .
	    "INSERT INTO test VALUES (0, '42', 0.42);"
);

$s = $db->prepare('SELECT * FROM test WHERE (a+2) = ?;');
$s->bindValue(1, 3);
$r = $s->execute();
var_dump($r->fetchArray(SQLITE3_ASSOC));

$s = $db->prepare('SELECT * FROM test WHERE a = ?;');
$s->bindValue(1, true);
$r = $s->execute();
var_dump($r->fetchArray(SQLITE3_ASSOC));

$s = $db->prepare('SELECT * FROM test WHERE a = ?;');
$s->bindValue(1, false);
$r = $s->execute();
var_dump($r->fetchArray(SQLITE3_ASSOC));

$s = $db->prepare('SELECT * FROM test WHERE c = ?;');
$s->bindValue(1, 3.15);
$r = $s->execute();
var_dump($r->fetchArray(SQLITE3_ASSOC));

?>
==DONE==
