<?php
mb_regex_encoding('iso-8859-1');
$test_str = 'Iñtërnâtiônàlizætiøn'; // Length = 20

var_dump(mb_ereg_search_setpos(50)); // OK
var_dump(mb_ereg_search_setpos(-1)); // Error

mb_ereg_search_init($test_str);

$positions = array( 5, 20, 21, 25, 0, -5, -20, -30);
foreach($positions as $pos) {
	echo("\n* Position: $pos :\n");
	var_dump(mb_ereg_search_setpos($pos));
	var_dump(mb_ereg_search_getpos());
}
?>
==DONE==
