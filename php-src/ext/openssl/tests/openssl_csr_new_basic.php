<?php

$a = 1;
var_dump(openssl_csr_new(1,$a));
var_dump(openssl_csr_new(1,$a,1,1));
$a = array();

$conf = array('config' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'openssl.cnf');
var_dump(openssl_csr_new(array(), $a, $conf, array()));

// this leaks
$a = array(1,2);
$b = array(1,2);
var_dump(openssl_csr_new($a, $b, $conf));

// options type check
$x = openssl_pkey_new($conf);
var_dump(openssl_csr_new(["countryName" => "DE"], $x, $conf + ["x509_extensions" => 0xDEADBEEF]));


echo "Done\n";
?>
