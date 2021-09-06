<?php
$soap = new \SoapClient(
    null,
    array(
        'location' => "http://localhost/soap.php",
        'uri' => "http://localhost/",
        'style' => SOAP_RPC,
        'trace' => true,
        'exceptions' => false,
    )
);
ini_set('precision', -1);
$soap->call(1.1);
echo $soap->__getLastRequest();
?>
===DONE===
