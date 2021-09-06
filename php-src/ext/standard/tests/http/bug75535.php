<?php
require 'server.inc';

$responses = array(
	"data://text/plain,HTTP/1.0 200 Ok\r\nContent-Length\r\n",
);

$pid = http_server("tcp://127.0.0.1:22351", $responses, $output);

var_dump(file_get_contents('http://127.0.0.1:22351/'));
var_dump($http_response_header);

http_server_kill($pid);
?>
==DONE==
