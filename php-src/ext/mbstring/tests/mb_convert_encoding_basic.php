<?php
/* Prototype  : string mb_convert_encoding(string $str, string $to_encoding [, mixed $from_encoding])
 * Description: Returns converted string in desired encoding
 * Source code: ext/mbstring/mbstring.c
 */

/*
 * Test basic functionality of mb_convert_encoding()
 */

echo "*** Testing mb_convert_encoding() : basic functionality ***\n";

//All strings are the same when displayed in their respective encodings
$sjis_string = base64_decode('k/qWe4zqg2WDTINYg2eCxYK3gUIwMTIzNIJUglWCVoJXgliBQg==');
$jis_string = base64_decode('GyRCRnxLXDhsJUYlLSU5JUgkRyQ5ISMbKEIwMTIzNBskQiM1IzYjNyM4IzkhIxsoQg==');
$euc_jp_string = base64_decode('xvzL3LjspcalraW5pcikx6S5oaMwMTIzNKO1o7ajt6O4o7mhow==');
$utf8_string = base64_decode('5pel5pys6Kqe44OG44Kt44K544OI44Gn44GZ44CCMDEyMzTvvJXvvJbvvJfvvJjvvJnjgII=');

echo "\n-- Convert to JIS --\n";
echo "JIS encoded string in base64:\n";
var_dump(base64_encode($jis_string));
echo "Converted Strings:\n";
var_dump(base64_encode(mb_convert_encoding($sjis_string, 'JIS', 'SJIS')));
var_dump(base64_encode(mb_convert_encoding($euc_jp_string, 'JIS', 'EUC-JP')));
var_dump(base64_encode(mb_convert_encoding($utf8_string, 'JIS', 'UTF-8')));

echo "\n-- Convert to EUC-JP --\n";
echo "EUC-JP encoded string in base64:\n";
var_dump(base64_encode($euc_jp_string));
echo "Converted Strings:\n";
var_dump(base64_encode(mb_convert_encoding($sjis_string, 'EUC-JP', 'SJIS')));
var_dump(base64_encode(mb_convert_encoding($jis_string, 'EUC-JP', 'JIS')));
var_dump(base64_encode(mb_convert_encoding($utf8_string, 'EUC-JP', 'UTF-8')));

echo "\n-- Convert to SJIS --\n";
echo "SJIS encoded string in base64:\n";
var_dump(base64_encode($sjis_string));
echo "Converted Strings:\n";
var_dump(base64_encode(mb_convert_encoding($jis_string, 'SJIS', 'JIS')));
var_dump(base64_encode(mb_convert_encoding($euc_jp_string, 'SJIS', 'EUC-JP')));
var_dump(base64_encode(mb_convert_encoding($utf8_string, 'SJIS', 'UTF-8')));

echo "\n-- Convert to UTF-8 --\n";
echo "UTF-8 encoded string in base64:\n";
var_dump(base64_encode($utf8_string));
echo "Converted Strings:\n";
var_dump(base64_encode(mb_convert_encoding($sjis_string, 'UTF-8', 'SJIS')));
var_dump(base64_encode(mb_convert_encoding($jis_string, 'UTF-8', 'JIS')));
var_dump(base64_encode(mb_convert_encoding($euc_jp_string, 'UTF-8', 'EUC-JP')));

echo "Done";
?>
