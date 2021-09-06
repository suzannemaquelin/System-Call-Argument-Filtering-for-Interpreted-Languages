<?php

try {
	try {
		x();
	} finally {
		print "ok\n";
	}
} catch (Error $e) {
	print "caught\n";
}

?>
