<?php
$str = 'foo';
mb_ereg_search_init($str);

mb_ereg_search('\A');
var_dump(mb_ereg_search_getpos());
var_dump(mb_ereg_search_getregs());

mb_ereg_search('\s*');
var_dump(mb_ereg_search_getpos());
var_dump(mb_ereg_search_getregs());

mb_ereg_search('\w+');
var_dump(mb_ereg_search_getpos());
var_dump(mb_ereg_search_getregs());

mb_ereg_search('\Z');
var_dump(mb_ereg_search_getpos());
var_dump(mb_ereg_search_getregs());
?>
