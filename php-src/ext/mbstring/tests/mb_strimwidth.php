<?php
// TODO: Add more encoding
//$debug = true;
ini_set('include_path', dirname(__FILE__));
include_once('common.inc');

// EUC-JP
$euc_jp = '0123この文字列は日本語です。EUC-JPを使っています。日本語は面倒臭い。';

print "String width: ".mb_strwidth($euc_jp,'EUC-JP')."\n";

print  "1: ". mb_strimwidth($euc_jp,  0, 15,'...','EUC-JP') . "\n";
print  "2: ". mb_strimwidth($euc_jp,  0, 100,'...','EUC-JP') . "\n";
print  "3: ". mb_strimwidth($euc_jp, 15, 100,'...','EUC-JP') . "\n";
print  "4: ". mb_strimwidth($euc_jp, -30, 5,'...','EUC-JP') . "\n";
print  "5: ". mb_strimwidth($euc_jp, 38, 5,'...','EUC-JP') . "\n";
print  "6: ". mb_strimwidth($euc_jp, 38, -25,'...','EUC-JP') . "\n";
print  "7: ". mb_strimwidth($euc_jp, -30, -25,'...','EUC-JP') . "\n";

$str = mb_strimwidth($euc_jp, 0, -100,'...','EUC-JP');
($str === FALSE) ? print "10 OK\n" : print "NG: $str\n";

$str = mb_strimwidth($euc_jp, 100, 10,'...','EUC-JP');
($str === FALSE) ? print "11 OK\n" : print "NG: $str\n";

$str = mb_strimwidth($euc_jp, -100, 10,'...','EUC-JP');
($str === FALSE) ? print "12 OK\n" : print "NG: $str\n";

$str = mb_strimwidth($euc_jp, -10, -12,'...','EUC-JP');
($str === FALSE) ? print "13 OK\n" : print "NG: $str\n";

?>
