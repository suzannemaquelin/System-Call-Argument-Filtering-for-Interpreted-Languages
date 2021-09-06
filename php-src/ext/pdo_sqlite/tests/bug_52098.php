<?php
if (getenv('REDIR_TEST_DIR') === false) putenv('REDIR_TEST_DIR='.dirname(__FILE__) . '/../../pdo/tests/');
require_once getenv('REDIR_TEST_DIR') . 'pdo_test.inc';
$db = PDOTest::factory();

@$db->exec("DROP TABLE test");
$db->exec("CREATE TABLE test (x int)");
$db->exec("INSERT INTO test VALUES (1)");

class MyStatement extends PDOStatement
{
    public function __call($name, $arguments)
    {
        echo "Calling object method '$name'" . implode(', ', $arguments). "\n";
    }
}
/*
Test prepared statement with PDOStatement class.
*/
$derived = $db->prepare('SELECT * FROM test', array(PDO::ATTR_STATEMENT_CLASS=>array('MyStatement')));
$derived->execute();
$derived->foo();
$derived->fetchAll();
$derived = null;

/*
Test regular statement with PDOStatement class.
*/
$db->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('MyStatement'));
$r =  $db->query('SELECT * FROM test');
echo $r->bar();
$r->fetchAll();
$r = null;

/*
Test object instance of PDOStatement class.
*/
$obj = new MyStatement;
echo $obj->lucky();

$db->exec("DROP TABLE test");
?>
===DONE===
