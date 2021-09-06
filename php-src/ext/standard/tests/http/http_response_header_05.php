<?php
require 'server.inc';

$responses = array(
	"data://text/plain,HTTP/1.0 200 Ok\r\n    \r\n\r\nBody",
);

$pid = http_server("tcp://127.0.0.1:22350", $responses, $output);

function test() {
    $f = file_get_contents('http://127.0.0.1:22350/');
    var_dump($f);
    var_dump($http_response_header);
}
test();

http_server_kill($pid);
?>
==DONE==