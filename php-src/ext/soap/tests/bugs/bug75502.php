<?php
/* The important part is that restriction>enumeration is used together with mem cache.
 * Reuse a WSDL file contains this. */
$client = new SoapClient(dirname(__FILE__)."/bug29236.wsdl");
?>
===DONE===
