<?php
$db = new SQLite3(':memory:');

$stmt = $db->prepare("select 1 = ?");

// bindParam crash
$i = 0;
$stmt->bindParam(0, $i);

var_dump($stmt->execute());
$db->close();
?>
