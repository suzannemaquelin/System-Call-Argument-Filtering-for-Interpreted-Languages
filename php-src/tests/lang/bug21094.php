<?php
class test {
	function hdlr($errno, $errstr, $errfile, $errline) {
		printf("[%d] errstr: %s, errfile: %s, errline: %d\n", $errno, $errstr, $errfile, $errline, $errstr);
	}
}

set_error_handler(array(new test(), "hdlr"));

trigger_error("test");
?>
