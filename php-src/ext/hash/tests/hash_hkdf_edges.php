<?php

/* Prototype  : string hkdf  ( string $algo  , string $ikm  [, int $length  , string $info = '' , string $salt = ''  ] )
 * Description: HMAC-based Key Derivation Function
 * Source code: ext/hash/hash.c
*/

echo "*** Testing hash_hkdf(): edge cases ***\n";

$ikm = 'input key material';

echo 'Length < digestSize: ', bin2hex(hash_hkdf('md5', $ikm, 7)), "\n";
echo 'Length % digestSize != 0: ', bin2hex(hash_hkdf('md5', $ikm, 17)), "\n";
echo 'Algo name case-sensitivity: ', (bin2hex(hash_hkdf('Md5', $ikm, 7)) === '98b16391063ece' ? 'true' : 'false'), "\n";
echo "Non-crypto algo name case-sensitivity:\n";
var_dump(hash_hkdf('jOaAt', $ikm));

?>
