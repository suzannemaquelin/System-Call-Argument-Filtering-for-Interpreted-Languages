--TEST--
mb_ereg_search_pos() # a test for the basic function of mb_ereg_search_pos
--SKIPIF--
<?php
if (!extension_loaded('mbstring')) die('skip mbstring not enabled');
?>
--FILE--
<?php
mb_regex_encoding('iso-8859-1');
$test_str = 'I?t?rn?ti?n?liz?ti?n';

if(mb_ereg_search_init($test_str))
{
	$val=mb_ereg_search_pos("n?ti?n");

	var_dump($val);

}
else{
	var_dump("false");
}
?>
--EXPECT--
array(2) {
  [0]=>
  int(5)
  [1]=>
  int(6)
}
