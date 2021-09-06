<?php

$client = new SoapClient(null, [
    "location"      =>  "test://",
    "uri"           =>  "test://",
    "exceptions"    =>  false,
    "trace"         =>  true,
]);
$client->__setSoapHeaders(new \SoapHeader('ns', 'Header', ['something' => 1]));
$client->__setSoapHeaders(new \SoapHeader('ns', 'Header', ['something' => 2]));
$client->test();
echo $client->__getLastRequest();

$client = new SoapClient(null, [
    "location"      =>  "test://",
    "uri"           =>  "test://",
    "exceptions"    =>  false,
    "trace"         =>  true,
]);
$client->__setSoapHeaders([new \SoapHeader('ns', 'Header', ['something' => 1])]);
$client->__setSoapHeaders([new \SoapHeader('ns', 'Header', ['something' => 2])]);
$client->test();
echo $client->__getLastRequest();

?>
