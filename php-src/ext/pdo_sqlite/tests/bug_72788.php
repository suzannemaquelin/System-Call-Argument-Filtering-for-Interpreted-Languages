<?php
if (getenv('REDIR_TEST_DIR') === false) putenv('REDIR_TEST_DIR='.dirname(__FILE__) . '/../../pdo/tests/');
require_once getenv('REDIR_TEST_DIR') . 'pdo_test.inc';

putenv("PDOTEST_ATTR=" . serialize(array(PDO::ATTR_PERSISTENT => true)));

function test() {
    $db = PDOTest::factory('PDO', false);
    $stmt = @$db->query("SELECT 1 FROM TABLE_DOES_NOT_EXIST");
    if ($stmt === false) {
        echo "Statement failed as expected\n";
    }
}

test();
test();
echo "Done";
?>
