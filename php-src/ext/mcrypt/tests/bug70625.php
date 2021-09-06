<?php

$key = 'secretkey';
$ciphertext = mcrypt_encrypt(MCRYPT_ARCFOUR, $key, 'payload', MCRYPT_MODE_STREAM);
var_dump(bin2hex($ciphertext));
$plaintext = mcrypt_decrypt(MCRYPT_ARCFOUR, $key, $ciphertext, MCRYPT_MODE_STREAM);
var_dump($plaintext);

?>
