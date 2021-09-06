<?php
mb_ereg_search_init('foo');

var_dump(mb_ereg_search_setpos(3));
var_dump(mb_ereg_search_getpos());

var_dump(mb_ereg_search('\Z'));
var_dump(mb_ereg_search_getpos());
?>
