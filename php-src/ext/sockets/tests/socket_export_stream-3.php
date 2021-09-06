<?php

$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($sock, '0.0.0.0', 58381);
$stream = socket_export_stream($sock);
var_dump($stream);
$so = socket_set_option($sock, IPPROTO_IP, MCAST_JOIN_GROUP, array(
	"group"	=> '224.0.0.23',
	"interface" => "lo",
));
var_dump($so);

$sendsock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
var_dump($sendsock);
$br = socket_bind($sendsock, '127.0.0.1');
$so = socket_sendto($sendsock, $m = "my message", strlen($m), 0, "224.0.0.23", 58381);
var_dump($so);

stream_set_blocking($stream, 0);
var_dump(fread($stream, strlen($m)));
echo "Done.\n";
