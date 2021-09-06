<?php

class bug70875 extends SOAPClient
{
	public function __doRequest($request, $location, $action, $version, $one_way = 0)
	{
		die("no SIGSEGV");
	}
}

$c = new bug70875(__DIR__.'/bug70875.wsdl', [
	'trace' => 1,
	'classmap' => [
		'TestService' => 'TestService',
		'TestServiceRQ' => 'TestServiceRQ',
		'RqHeader' => 'RqHeader',
	],
]);


class TestService
{
    public $TestServiceRQ;
}

class TestServiceRQ
{
	public $RqHeader;
}

class RqHeader
{
}

$r = new TestService();
$r->TestServiceRQ = new TestServiceRQ();
$r->TestServiceRQ->RqHeader = new RqHeader();

$c->testService($r);

?>
