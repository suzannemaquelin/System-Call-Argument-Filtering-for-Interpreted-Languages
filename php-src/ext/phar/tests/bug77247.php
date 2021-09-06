<?php
try {
var_dump(new Phar('a/.b', 0,'test.phar'));
} catch(UnexpectedValueException $e) {
	echo "OK";
}
?>
