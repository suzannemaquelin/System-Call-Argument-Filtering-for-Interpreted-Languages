<?php
var_dump($res = openssl_x509_read("file://" . dirname(__FILE__) . "/cert.crt"));
openssl_x509_free($res);
var_dump($res);
openssl_x509_free(false);
?>
