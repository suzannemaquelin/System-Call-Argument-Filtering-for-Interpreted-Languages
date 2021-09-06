<?php
// simple tests
$a = 1;
$b = array(1);
$c = array(1);
$d = array(1);

var_dump(openssl_seal($a, $b, $c, $d));
var_dump(openssl_seal($a, $a, $a, array()));
var_dump(openssl_seal($c, $c, $c, 1));
var_dump(openssl_seal($b, $b, $b, ""));

// tests with cert
$data = "openssl_open() test";
$pub_key = "file://" . dirname(__FILE__) . "/public.key";
$wrong = "wrong";

var_dump(openssl_seal($data, $sealed, $ekeys, array($pub_key)));                  // no output
var_dump(openssl_seal($data, $sealed, $ekeys, array($pub_key, $pub_key)));        // no output
var_dump(openssl_seal($data, $sealed, $ekeys, array($pub_key, $wrong)));
var_dump(openssl_seal($data, $sealed, $ekeys, $pub_key));
var_dump(openssl_seal($data, $sealed, $ekeys, array()));
var_dump(openssl_seal($data, $sealed, $ekeys, array($wrong)));

echo "Done\n";
?>
