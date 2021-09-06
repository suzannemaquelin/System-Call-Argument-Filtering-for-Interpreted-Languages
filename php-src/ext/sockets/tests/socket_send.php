<?php
$port = 80;
$host = "yahoo.com";
$stringSocket = "send_socket_to_connected_socket";
$stringSocketLenght = strlen($stringSocket);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$socketConn = socket_connect($socket, $host, $port);

if(socket_send($socket, $stringSocket, $stringSocketLenght, MSG_OOB)===$stringSocketLenght){
  print("okey\n");
}

if(socket_send($socket, $stringSocket, $stringSocketLenght, MSG_EOR)===$stringSocketLenght){
  print("okey\n");
}

if(socket_send($socket, $stringSocket, $stringSocketLenght, MSG_EOF)===$stringSocketLenght){
  print("okey\n");
}

if(socket_send($socket, $stringSocket, $stringSocketLenght, MSG_DONTROUTE)===$stringSocketLenght){
  print("okey\n");
}
?>
<?php
socket_close($socket);
unset($port);
unset($host);
unset($stringSocket);
unset($stringSocketLenght);
unset($socket);
unset($socketConn);
?>
