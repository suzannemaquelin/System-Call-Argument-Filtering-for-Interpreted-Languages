--TEST--
Test mb_strripos() function : usage variations - Pass different integers as $offset argument
--SKIPIF--
<?php
extension_loaded('mbstring') or die('skip');
function_exists('mb_strripos') or die("skip mb_strripos() is not available in this build");
?>
--FILE--
<?php
/* Prototype  : int mb_strripos(string haystack, string needle [, int offset [, string encoding]])
 * Description: Finds position of last occurrence of a string within another, case insensitive
 * Source code: ext/mbstring/mbstring.c
 * Alias to functions:
 */

/*
 * Test how mb_strripos() behaves when passed different integers as $offset argument
 * The character length of $string_ascii and $string_mb is the same,
 * and the needle appears at the same positions in both strings
 */

mb_internal_encoding('UTF-8');

echo "*** Testing mb_strripos() : usage variations ***\n";

$string_ascii = b'+Is an English string'; //21 chars
$needle_ascii = b'G';

$string_mb = base64_decode('5pel5pys6Kqe44OG44Kt44K544OI44Gn44GZ44CCMDEyMzTvvJXvvJbvvJfvvJjvvJnjgII='); //21 chars
$needle_mb = base64_decode('44CC');

/*
 * Loop through integers as multiples of ten for $offset argument
 * mb_strripos should not be able to accept negative values as $offset.
 * 60 is larger than *BYTE* count for $string_mb
 */
for ($i = -10; $i <= 60; $i += 10) {
	echo "\n**-- Offset is: $i --**\n";
	echo "-- ASCII String --\n";
	var_dump(mb_strripos($string_ascii, $needle_ascii, $i));
	echo "--Multibyte String --\n";
	var_dump(mb_strripos($string_mb, $needle_mb, $i, 'UTF-8'));
}

echo "Done";
?>
--EXPECTF--
*** Testing mb_strripos() : usage variations ***

**-- Offset is: -10 --**
-- ASCII String --
int(9)
--Multibyte String --
int(9)

**-- Offset is: 0 --**
-- ASCII String --
int(20)
--Multibyte String --
int(20)

**-- Offset is: 10 --**
-- ASCII String --
int(20)
--Multibyte String --
int(20)

**-- Offset is: 20 --**
-- ASCII String --
int(20)
--Multibyte String --
int(20)

**-- Offset is: 30 --**
-- ASCII String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)
--Multibyte String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)

**-- Offset is: 40 --**
-- ASCII String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)
--Multibyte String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)

**-- Offset is: 50 --**
-- ASCII String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)
--Multibyte String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)

**-- Offset is: 60 --**
-- ASCII String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)
--Multibyte String --

Warning: mb_strripos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)
Done
