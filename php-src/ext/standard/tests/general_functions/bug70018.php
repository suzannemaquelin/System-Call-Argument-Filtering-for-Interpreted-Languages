<?php
$output = array();

$test_fl = dirname(__FILE__) . DIRECTORY_SEPARATOR . md5(uniqid());
file_put_contents($test_fl, '<?php echo "abc\f\n \n";');

exec(PHP_BINARY . " -n $test_fl", $output);

var_dump($output);

@unlink($test_fl);
?>
