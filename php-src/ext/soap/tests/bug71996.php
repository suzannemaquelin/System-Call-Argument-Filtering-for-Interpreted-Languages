<?php

$client = new class(null, ['location' => '', 'uri' => 'http://example.org']) extends SoapClient {
    public function __doRequest($request, $location, $action, $version, $one_way = 0) {
        echo $request, "\n";
        return '';
    }
};

$ref = array("foo");
$data = array(&$ref);
$client->foo($data);

$ref = array("def" => "foo");
$data = array("abc" => &$ref);
$client->foo($data);

?>
