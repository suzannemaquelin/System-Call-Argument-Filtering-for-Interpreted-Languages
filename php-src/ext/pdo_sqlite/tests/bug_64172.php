<?php
if (getenv('REDIR_TEST_DIR') === false) putenv('REDIR_TEST_DIR='.dirname(__FILE__) . '/../../pdo/tests/');
require_once getenv('REDIR_TEST_DIR') . 'pdo_test.inc';

$db = PDOTest::factory();

@$db->exec("DROP TABLE test");
$db->exec("CREATE TABLE test (x int)");
$db->exec("INSERT INTO test VALUES (1)");

echo "===FAIL===\n";
$db->query('SELECT * FROM bad_table');
echo "\n";
echo "===TEST===\n";
var_dump(is_string($db->errorInfo()[0])) . "\n";
var_dump(is_int($db->errorInfo()[1])) . "\n";
var_dump(is_string($db->errorInfo()[2])) . "\n";
echo "===GOOD===\n";
$stmt = $db->query('SELECT * FROM test');
$stmt->fetchAll();
$stmt = null;
var_dump($db->errorInfo());

echo "===FAIL===\n";
$db->exec("INSERT INTO bad_table VALUES(1)");
echo "\n";
echo "===TEST===\n";
var_dump(is_string($db->errorInfo()[0])) . "\n";
var_dump(is_int($db->errorInfo()[1])) . "\n";
var_dump(is_string($db->errorInfo()[2])) . "\n";
echo "===GOOD===\n";
$db->exec("INSERT INTO test VALUES (2)");
var_dump($db->errorInfo());

$db->exec("DROP TABLE test");
?>
===DONE===
