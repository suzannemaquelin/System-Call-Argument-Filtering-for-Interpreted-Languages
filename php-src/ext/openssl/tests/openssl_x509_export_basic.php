<?php
$cert_file = dirname(__FILE__) . "/cert.crt";

$a = file_get_contents($cert_file);
$b = "file://" . $cert_file;
$c = "invalid cert";
$d = openssl_x509_read($a);
$e = array();

var_dump(openssl_x509_export($a, $output));  // read cert as a binary string
var_dump(openssl_x509_export($b, $output2)); // read cert from a filename string
var_dump(openssl_x509_export($c, $output3)); // read an invalid cert, fails
var_dump(openssl_x509_export($d, $output4)); // read cert from a resource
var_dump(openssl_x509_export($e, $output5)); // read an array, fails

if (PHP_EOL !== "\n") {
    $a = str_replace(PHP_EOL, "\n", $a);
}

var_dump(strcmp($output, $a));
var_dump(strcmp($output, $output2));
var_dump(strcmp($output, $output3));
var_dump(strcmp($output, $output4)); // different
var_dump(strcmp($output, $output5)); // different
?>
