<?php

$db_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . '私はガラスを食べられます.db';
$db = new SQLite3($db_file);
//require_once(dirname(__FILE__) . '/new_db.inc');

var_dump($db);
var_dump($db->close());

unlink($db_file);
echo "Done\n";
?>
