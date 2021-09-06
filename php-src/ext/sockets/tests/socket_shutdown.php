<?php
$host = "yahoo.com";
$port = 80;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$socketConn = socket_connect($socket, $host, $port);
var_dump(socket_shutdown($socket,0));
socket_close($socket);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$socketConn = socket_connect($socket, $host, $port);
var_dump(socket_shutdown($socket,1));
socket_close($socket);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$socketConn = socket_connect($socket, $host, $port);
var_dump(socket_shutdown($socket,2));
socket_close($socket);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
var_dump(socket_shutdown($socket,0));

$socketConn = socket_connect($socket, $host, $port);
var_dump(socket_shutdown($socket,-1));
socket_close($socket);
?>
