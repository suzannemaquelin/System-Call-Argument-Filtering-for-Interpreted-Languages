<?php
if (getenv('REDIR_TEST_DIR') === false) putenv('REDIR_TEST_DIR='.dirname(__FILE__) . '/../../pdo/tests/');
require_once getenv('REDIR_TEST_DIR') . 'pdo_test.inc';
$db = PDOTest::factory();
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$db->exec('CREATE TABLE test(id int)');
$db->exec('INSERT INTO test VALUES(1)');
switch ($db->getAttribute(PDO::ATTR_DRIVER_NAME)) {
	case 'dblib':
		// if :limit is used, the value will be quoted as '1', which is invalid syntax
		// this is a bug, to be addressed separately from adding these tests to pdo_dblib
		$sql = 'SELECT TOP 1 * FROM test';
		break;
	case 'odbc':
		$sql = 'SELECT TOP (:limit) * FROM test';
		break;
	case 'firebird':
		$sql = 'SELECT FIRST :limit * FROM test';
		break;
	case 'oci':
		//$sql = 'SELECT * FROM test FETCH FIRST :limit ROWS ONLY';  // Oracle 12c syntax
		$sql = "select id from (select a.*, rownum rnum from (SELECT * FROM test) a where rownum <= :limit)";
		break;
	default:
		$sql = 'SELECT * FROM test LIMIT :limit';
		break;
}
$stmt = $db->prepare($sql);
$stmt->bindValue('limit', 1, PDO::PARAM_INT);
if(!($res = $stmt->execute())) var_dump($stmt->errorInfo());
if(!($res = $stmt->execute())) var_dump($stmt->errorInfo());
var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
