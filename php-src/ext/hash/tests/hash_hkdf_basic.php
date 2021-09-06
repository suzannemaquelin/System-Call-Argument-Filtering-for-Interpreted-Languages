<?php

/* Prototype  : string hkdf  ( string $algo  , string $ikm  [, int $length  , string $info = '' , string $salt = ''  ] )
 * Description: HMAC-based Key Derivation Function
 * Source code: ext/hash/hash.c
*/

echo "*** Testing hash_hkdf(): basic functionality ***\n";

$ikm = 'input key material';

echo 'md2: ', bin2hex(hash_hkdf('md2', $ikm)), "\n";
echo 'md4: ', bin2hex(hash_hkdf('md4', $ikm)), "\n";
echo 'md5: ', bin2hex(hash_hkdf('md5', $ikm)), "\n";
echo 'sha1: ', bin2hex(hash_hkdf('sha1', $ikm)), "\n";
echo 'sha224: ', bin2hex(hash_hkdf('sha224', $ikm)), "\n";
echo 'sha256: ', bin2hex(hash_hkdf('sha256', $ikm)), "\n";
echo 'sha384: ', bin2hex(hash_hkdf('sha384', $ikm)), "\n";
echo 'sha512: ', bin2hex(hash_hkdf('sha512', $ikm)), "\n";
echo 'ripemd128: ', bin2hex(hash_hkdf('ripemd128', $ikm)), "\n";
echo 'ripemd160: ', bin2hex(hash_hkdf('ripemd160', $ikm)), "\n";
echo 'ripemd256: ', bin2hex(hash_hkdf('ripemd256', $ikm)), "\n";
echo 'ripemd320: ', bin2hex(hash_hkdf('ripemd320', $ikm)), "\n";
echo 'whirlpool: ', bin2hex(hash_hkdf('whirlpool', $ikm)), "\n";
echo 'tiger128,3: ', bin2hex(hash_hkdf('tiger128,3', $ikm)), "\n";
echo 'tiger160,3: ', bin2hex(hash_hkdf('tiger160,3', $ikm)), "\n";
echo 'tiger192,3: ', bin2hex(hash_hkdf('tiger192,3', $ikm)), "\n";
echo 'tiger128,4: ', bin2hex(hash_hkdf('tiger128,4', $ikm)), "\n";
echo 'tiger160,4: ', bin2hex(hash_hkdf('tiger160,4', $ikm)), "\n";
echo 'tiger192,4: ', bin2hex(hash_hkdf('tiger192,4', $ikm)), "\n";
echo 'haval128,3: ', bin2hex(hash_hkdf('haval128,3', $ikm)), "\n";
echo 'haval160,3: ', bin2hex(hash_hkdf('haval160,3', $ikm)), "\n";
echo 'haval192,3: ', bin2hex(hash_hkdf('haval192,3', $ikm)), "\n";
echo 'haval224,3: ', bin2hex(hash_hkdf('haval224,3', $ikm)), "\n";
echo 'haval256,3: ', bin2hex(hash_hkdf('haval256,3', $ikm)), "\n";
echo 'haval128,4: ', bin2hex(hash_hkdf('haval128,4', $ikm)), "\n";
echo 'haval160,4: ', bin2hex(hash_hkdf('haval160,4', $ikm)), "\n";
echo 'haval192,4: ', bin2hex(hash_hkdf('haval192,4', $ikm)), "\n";
echo 'haval224,4: ', bin2hex(hash_hkdf('haval224,4', $ikm)), "\n";
echo 'haval256,4: ', bin2hex(hash_hkdf('haval256,4', $ikm)), "\n";
echo 'haval128,5: ', bin2hex(hash_hkdf('haval128,5', $ikm)), "\n";
echo 'haval160,5: ', bin2hex(hash_hkdf('haval160,5', $ikm)), "\n";
echo 'haval192,5: ', bin2hex(hash_hkdf('haval192,5', $ikm)), "\n";
echo 'haval224,5: ', bin2hex(hash_hkdf('haval224,5', $ikm)), "\n";
echo 'haval256,5: ', bin2hex(hash_hkdf('haval256,5', $ikm)), "\n";
echo 'snefru: ', bin2hex(hash_hkdf('snefru', $ikm)), "\n";
echo 'snefru256: ', bin2hex(hash_hkdf('snefru256', $ikm)), "\n";
echo 'gost: ', bin2hex(hash_hkdf('gost', $ikm)), "\n";

?>
