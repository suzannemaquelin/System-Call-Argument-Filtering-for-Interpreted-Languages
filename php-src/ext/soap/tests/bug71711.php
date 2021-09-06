<?php

$client = new class(null, [ 'location' => '', 'uri' => 'http://example.org']) extends SoapClient {
    public function __doRequest($request, $location, $action, $version, $one_way = 0) {
        echo $request;
        return '';
    }
};
$ref = array("foo");
$data = new stdClass;
$data->prop =& $ref;
$client->foo($data);

?>
