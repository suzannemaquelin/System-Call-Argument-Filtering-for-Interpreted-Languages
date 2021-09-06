<?php
ini_set('memory_limit', -1);
$var_2  = str_repeat('A', 1024*1024*64);
escapeshellcmd($var_2);

?>
===DONE===
