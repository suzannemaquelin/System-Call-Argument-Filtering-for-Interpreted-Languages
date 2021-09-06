<?php

function section($func, $haystack, $needle)
{
	echo "\n------- $func -----------\n\n";
	foreach(array(0, 3, 6, 9, 11, 12, -1, -3, -6, -20) as $offset) {
		echo "> Offset: $offset\n";
		var_dump($func($haystack,$needle,$offset));
	}
}

section('strpos'     , "abc abc abc"  , "abc");
section('mb_strpos'  , "●○◆ ●○◆ ●○◆", "●○◆");

section('stripos'    , "abc abc abc"  , "abc");
section('mb_stripos' , "●○◆ ●○◆ ●○◆", "●○◆");

section('strrpos'    , "abc abc abc"  , "abc");
section('mb_strrpos' , "●○◆ ●○◆ ●○◆", "●○◆");

section('strripos'   , "abc abc abc"  , "abc");
section('mb_strripos', "●○◆ ●○◆ ●○◆", "●○◆");
?>
