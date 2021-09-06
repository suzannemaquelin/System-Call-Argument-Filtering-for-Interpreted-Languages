<?php

var_dump(socket_export_stream());
var_dump(socket_export_stream(1, 2));
var_dump(socket_export_stream(1));
var_dump(socket_export_stream(new stdclass));
var_dump(socket_export_stream(fopen(__FILE__, "rb")));
var_dump(socket_export_stream(stream_socket_server("udp://127.0.0.1:58392", $errno, $errstr, STREAM_SERVER_BIND)));
$s = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
var_dump($s);
socket_close($s);
var_dump(socket_export_stream($s));


echo "Done.";
