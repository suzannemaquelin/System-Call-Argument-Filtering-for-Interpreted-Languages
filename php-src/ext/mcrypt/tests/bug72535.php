<?php
$passphrase = 'My secret';
$plaintext = 'Secret secret secret data';

$iv = substr(md5('iv' . $passphrase, true), 0, 8);
$key = substr(md5('pass1' . $passphrase, true) .
	              md5('pass2' . $passphrase, true), 0, 24);
$opts = array('iv' => $iv, 'key' => $key, 'mode' => 'stream');

$expected = substr($plaintext . $plaintext, 0, 48);

$fp = fopen('php://memory', 'wb+');
stream_filter_append($fp, 'mcrypt.arcfour', STREAM_FILTER_WRITE, $opts);
fwrite($fp, $plaintext);
?>
==NOCRASH==
