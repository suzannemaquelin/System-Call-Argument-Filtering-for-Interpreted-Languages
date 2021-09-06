<?php
require_once __DIR__ . "/cipher_tests.inc";
$method = 'aes-128-gcm';
$tests = openssl_get_cipher_tests($method);

foreach ($tests as $idx => $test) {
    echo "TEST $idx\n";
    $ct = openssl_encrypt($test['pt'], $method, $test['key'], OPENSSL_RAW_DATA,
        $test['iv'], $tag, $test['aad'], strlen($test['tag']));
    var_dump($test['ct'] === $ct);
    var_dump($test['tag'] === $tag);
}

// Empty IV error
var_dump(openssl_encrypt('data', $method, 'password', 0, NULL, $tag, ''));

// Failing to retrieve tag (max is 16 bytes)
var_dump(openssl_encrypt('data', $method, 'password', 0, str_repeat('x', 32), $tag, '', 20));

// Failing when no tag supplied
var_dump(openssl_encrypt('data', $method, 'password', 0, str_repeat('x', 32)));
?>
