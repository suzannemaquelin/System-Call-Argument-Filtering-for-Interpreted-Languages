<?php
$ctxt = stream_context_create([
	"socket" => [
		"tcp_nodelay" => true
	]
]);

$stream = fopen("http://www.php.net", "r", false,  $ctxt);

$socket =
	@socket_import_stream($stream);

var_dump(socket_get_option($socket, STREAM_IPPROTO_TCP, TCP_NODELAY) > 0);
?>
