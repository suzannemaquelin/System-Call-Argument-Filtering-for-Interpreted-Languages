<?php

$pkey = openssl_pkey_new(array(
	'digest_alg' => 'sha256',
	'private_key_bits' => 1024,
	'private_key_type' => OPENSSL_KEYTYPE_RSA,
	'encrypt_key' => false,
	'config' => __DIR__ . DIRECTORY_SEPARATOR . 'openssl.cnf',
));
$details = openssl_pkey_get_details($pkey);
$test_pubkey = $details['key'];
$pubkey = openssl_pkey_get_public($test_pubkey);
$encrypted = null;
$ekeys = array();
$result = openssl_seal('test phrase', $encrypted, $ekeys, array($pubkey), 'AES-256-CBC');
echo "Done";
?>
