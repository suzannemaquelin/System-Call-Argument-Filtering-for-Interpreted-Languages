<?php
try {
    $x = new SoapClient('http://i_dont_exist.com/some.wsdl');
} catch (SoapFault $e) {
    echo "catched\n";
}

$error = error_get_last();
if ($error === null) {
    echo "ok\n";
}
?>
