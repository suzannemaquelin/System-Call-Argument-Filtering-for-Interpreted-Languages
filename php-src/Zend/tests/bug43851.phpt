--TEST--
Bug #43851 (Memory corrution on reuse of assigned value)
--FILE--
<?php
foo();
function foo() {
	global $LAST;
	($LAST = $LAST + 0) * 1;
	printf("ok\n");
}
?>
--EXPECT--
ok
