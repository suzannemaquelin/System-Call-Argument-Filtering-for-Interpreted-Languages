<?php
require 'server.inc';

$options = [
  'http' => [
    'protocol_version' => '1.1',
    'header' => 'Connection: Close'
  ],
];

$ctx = stream_context_create($options);

$responses = [
	"data://text/plain,000000000100\xA\xA"
];
$pid = http_server('tcp://127.0.0.1:12342', $responses);

echo @file_get_contents('http://127.0.0.1:12342/', false, $ctx);

http_server_kill($pid);

?>
DONE
