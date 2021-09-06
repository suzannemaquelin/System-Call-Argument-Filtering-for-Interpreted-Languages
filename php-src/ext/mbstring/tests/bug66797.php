<?php
var_dump(
    mb_substr('bar', 0, 0x7fffffff),
    mb_substr('bar', 0, 0x80000000),
    mb_substr('bar', 0xffffffff, 1),
    mb_substr('bar', 0x100000000, 1)
);
?>
==DONE==
