<?php
$pkcsfile = dirname(__FILE__) . "/openssl_pkcs12_export_to_file__pkcsfile.tmp";

$cert_file = dirname(__FILE__) . "/public.crt";
$cert = file_get_contents($cert_file);
$cert_path = "file://" . $cert_file;
$priv_file = dirname(__FILE__) . "/private.crt";
$priv = file_get_contents($priv_file);
$priv_path = "file://" . $priv_file;
$cert_res = openssl_x509_read($cert);
$priv_res = openssl_pkey_get_private($priv);
$pass = "test";
$invalid = "";
$invalid_path = dirname(__FILE__) . "/invalid_path";
$opts = [];

var_dump(openssl_pkcs12_export_to_file($cert, $pkcsfile, $priv, $pass));
var_dump(openssl_pkcs12_read(file_get_contents($pkcsfile), $opts, $pass));
var_dump(openssl_pkcs12_export_to_file($cert_path, $pkcsfile, $priv_path, $pass));
var_dump(openssl_pkcs12_read(file_get_contents($pkcsfile), $opts, $pass));
var_dump(openssl_pkcs12_export_to_file($cert_res, $pkcsfile, $priv_res, $pass));
var_dump(openssl_pkcs12_read(file_get_contents($pkcsfile), $opts, $pass));
var_dump(openssl_pkcs12_export_to_file($cert_res, $pkcsfile, $priv_res, $pass, array($cert)));
var_dump(openssl_pkcs12_read(file_get_contents($pkcsfile), $opts, $pass));

var_dump(openssl_pkcs12_export_to_file($invalid, $pkcsfile, $invalid, $pass));
var_dump(openssl_pkcs12_export_to_file($invalid_path, $pkcsfile, $invalid_path, $pass));
var_dump(openssl_pkcs12_export_to_file($priv_res, $pkcsfile, $cert_res, $pass));
?>
