<?php
$fd = fopen("php://memory", "w+");
var_dump(ftruncate($fd, -1));
?>
==DONE==
