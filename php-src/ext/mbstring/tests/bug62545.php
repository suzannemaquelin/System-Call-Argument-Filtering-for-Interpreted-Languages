<?php
var_dump(
    bin2hex(mb_convert_encoding("\x98", 'UTF-8', 'Windows-1251')),
    bin2hex(mb_convert_encoding("\x81\x8d\x8f\x90\x9d", 'UTF-8', 'Windows-1252'))
);
?>
===DONE===
