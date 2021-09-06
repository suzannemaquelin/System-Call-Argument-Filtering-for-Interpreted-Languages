<?php
var_dump(mb_ereg("000||0\xfa","0"));
var_dump(mb_ereg("(?i)000000000000000000000\xf0",""));
var_dump(mb_ereg("0000\\"."\xf5","0"));
var_dump(mb_ereg("(?i)FFF00000000000000000\xfd",""));
?>
