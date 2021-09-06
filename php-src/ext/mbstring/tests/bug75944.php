<?php
var_dump(mb_detect_encoding(chr(0xfe), array('CP-1251'))); // letter '?'
var_dump(mb_detect_encoding(chr(0xff), array('CP-1251'))); // letter '?'
?>
