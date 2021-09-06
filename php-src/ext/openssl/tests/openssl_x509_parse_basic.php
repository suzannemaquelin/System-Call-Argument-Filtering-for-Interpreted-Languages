<?php
$cert = "file://" . dirname(__FILE__) . "/cert.crt";

$parsedCert = openssl_x509_parse($cert);
var_dump($parsedCert === openssl_x509_parse(openssl_x509_read($cert)));
var_dump($parsedCert);
var_dump(openssl_x509_parse($cert, false));
?>
