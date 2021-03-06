<?php
ini_set("soap.wsdl_cache_enabled", 0);

class foo {
	public    $a="a";
	private   $b="b";
	protected $c="c";
}

function test($x) {
  return $x;
}

class LocalSoapClient extends SoapClient {

  function __construct($wsdl, $options) {
    parent::__construct($wsdl, $options);
    $this->server = new SoapServer($wsdl, $options);
    $this->server->addFunction('test');
  }

  function __doRequest($request, $location, $action, $version, $one_way = 0) {
    ob_start();
    $this->server->handle($request);
    $response = ob_get_contents();
    ob_end_clean();
    return $response;
  }
}

$x = new LocalSoapClient(dirname(__FILE__)."/bug30928.wsdl",
                         array());
var_dump($x->test(new foo()));

$x = new LocalSoapClient(dirname(__FILE__)."/bug30928.wsdl",
                         array("classmap" => array('testType'=>'foo')));
var_dump($x->test(new foo()));

echo "ok\n";
?>
