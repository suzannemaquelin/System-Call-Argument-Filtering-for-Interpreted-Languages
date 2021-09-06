<?php
$fp = fopen(dirname(__FILE__) . "/cert.crt","r");
$a = fread($fp,8192);
fclose($fp);

$b = "file://" . dirname(__FILE__) . "/cert.crt";
$c = "invalid cert";
$d = openssl_x509_read($a);
$e = array();
$f = array($b);

var_dump(openssl_x509_read($a)); // read cert as a string
var_dump(openssl_x509_read($b)); // read cert as a filename string
var_dump(openssl_x509_read($c)); // read an invalid cert, fails
var_dump(openssl_x509_read($d)); // read cert from a resource
var_dump(openssl_x509_read($e)); // read an array
var_dump(openssl_x509_read($f)); // read an array with the filename
?>
