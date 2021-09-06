<?php
$p12_file = dirname(__FILE__) . "/p12_with_extra_certs.p12";
$p12 = file_get_contents($p12_file);
$certs = array();
$pass = "qwerty";

var_dump(openssl_pkcs12_read("", $certs, ""));
var_dump(openssl_pkcs12_read($p12, $certs, ""));
var_dump(openssl_pkcs12_read($p12, $certs, $pass));
var_dump($certs);
?>
