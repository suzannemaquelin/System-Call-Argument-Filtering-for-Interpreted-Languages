<?php
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$socketConn = socket_connect($socket, "127.0.0.1", 21248);
var_dump(socket_last_error($socket));
socket_clear_error($socket);
var_dump(socket_last_error($socket));
?>
