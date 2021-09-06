<?php
$client = new SoapClient(__DIR__ . DIRECTORY_SEPARATOR . 'bug76348.wsdl', [
    'cache_wsdl' => WSDL_CACHE_MEMORY,
]);
?>
===DONE===
