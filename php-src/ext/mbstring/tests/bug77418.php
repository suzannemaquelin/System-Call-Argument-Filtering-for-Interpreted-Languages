<?php
mb_regex_encoding("UTF-32");
var_dump(mb_split("\x00\x00\x00\x5c\x00\x00\x00B","000000000000000000000000000000"));
?>
