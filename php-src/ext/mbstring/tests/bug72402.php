<?php
function throwit() {
	throw new Exception('it');
}
$var10 = "throwit";
try {
	$var14 = mb_ereg_replace_callback("", $var10, "");
} catch(Exception $e) {}
?>
DONE
