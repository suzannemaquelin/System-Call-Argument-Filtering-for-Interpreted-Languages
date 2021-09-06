<?php

/* Prototype  : string hkdf  ( string $algo  , string $ikm  [, int $length  , string $info = '' , string $salt = ''  ] )
 * Description: HMAC-based Key Derivation Function
 * Source code: ext/hash/hash.c
*/

$ikm = 'input key material';

echo "*** Testing hash_hkdf(): error conditions ***\n";

echo "\n-- Testing hash_hkdf() function with less than expected no. of arguments --\n";
var_dump(hash_hkdf());
var_dump(hash_hkdf('sha1'));

echo "\n-- Testing hash_hkdf() function with more than expected no. of arguments --\n";
var_dump(hash_hkdf('sha1', $ikm, 20, '', '', 'extra parameter'));

echo "\n-- Testing hash_hkdf() function with invalid hash algorithm --\n";
var_dump(hash_hkdf('foo', $ikm));

echo "\n-- Testing hash_hkdf() function with non-cryptographic hash algorithm --\n";
var_dump(hash_hkdf('adler32', $ikm));
var_dump(hash_hkdf('crc32', $ikm));
var_dump(hash_hkdf('crc32b', $ikm));
var_dump(hash_hkdf('fnv132', $ikm));
var_dump(hash_hkdf('fnv1a32', $ikm));
var_dump(hash_hkdf('fnv164', $ikm));
var_dump(hash_hkdf('fnv1a64', $ikm));
var_dump(hash_hkdf('joaat', $ikm));

echo "\n-- Testing hash_hkdf() function with invalid parameters --\n";
var_dump(hash_hkdf('sha1', ''));
var_dump(hash_hkdf('sha1', $ikm, -1));
var_dump(hash_hkdf('sha1', $ikm, 20 * 255 + 1)); // Length can't be more than 255 times the hash digest size
?>
===Done===
