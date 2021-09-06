<?php
$db = new SQLite3(':memory:');
$db->exec("CREATE TABLE foo (bar REAL)");
$stmt = $db->prepare("INSERT INTO foo VALUES (:bar)");
$stmt->bindValue(':bar', 17, SQLITE3_FLOAT);
$stmt->execute();
var_dump($db->querySingle("SELECT bar FROM foo LIMIT 1"));
?>
===DONE===
