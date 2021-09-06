<?php
error_reporting(E_ALL);

/* Prototype  : string mcrypt_ecb(int cipher, string key, string data, int mode, string iv)
 * Description: ECB crypt/decrypt data using key key with cipher cipher starting with iv
 * Source code: ext/mcrypt/mcrypt.c
 * Alias to functions:
 */

$cipher = MCRYPT_TRIPLEDES;
$data = b"This is the secret message which must be encrypted";

// tripledes uses keys up to 192 bits (24 bytes)
$keys = array(
   b'12345678',
   b'12345678901234567890',
   b'123456789012345678901234',
   b'12345678901234567890123456'
);
// tripledes is a block cipher of 64 bits (8 bytes)
$ivs = array(
   b'1234',
   b'12345678',
   b'123456789'
);

$iv = b'12345678';
echo "\n--- testing different key lengths\n";
foreach ($keys as $key) {
   echo "\nkey length=".strlen($key)."\n";
   var_dump(bin2hex(mcrypt_encrypt($cipher, $key, $data, MCRYPT_MODE_ECB, $iv)));
}

$key = b"1234567890123456\0\0\0\0\0\0\0\0";
echo "\n--- testing different iv lengths\n";
foreach ($ivs as $iv) {
   echo "\niv length=".strlen($iv)."\n";
   var_dump(bin2hex(mcrypt_encrypt($cipher, $key, $data, MCRYPT_MODE_ECB, $iv)));
}
?>
===DONE===
