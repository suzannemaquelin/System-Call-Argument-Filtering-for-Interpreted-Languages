<?php
include __DIR__."/mcast_helpers.php.inc";
$path = __DIR__ . "/unix_sock";

@unlink($path);

echo "creating send socket\n";
$sends1 = socket_create(AF_UNIX, SOCK_DGRAM, 0) or die("err");
var_dump($sends1);
socket_set_nonblock($sends1) or die("Could not put in non-blocking mode");

echo "creating receive socket\n";
$s = socket_create(AF_UNIX, SOCK_DGRAM, 0) or die("err");
var_dump($s);
$br = socket_bind($s, $path) or die("err");
var_dump($br);
socket_set_nonblock($sends1) or die("Could not put in non-blocking mode");
socket_set_option($s, SOL_SOCKET, SO_PASSCRED, 1) or die("could not set SO_PASSCRED");


//$r = socket_sendmsg($sends1, [
//  "iov" => ["test ", "thing", "\n"],
//], 0);
$r = socket_sendto($sends1, $msg = "dread", strlen($msg), 0, $path);
var_dump($r);
checktimeout($s, 500);

$data = [
    "name" => [],
    "buffer_size" => 2000,
    "controllen" => socket_cmsg_space(SOL_SOCKET, SCM_CREDENTIALS)
];
if (!socket_recvmsg($s, $data, 0)) die("recvmsg");
print_r($data);

$pid = getmypid();
var_dump($data['control'][0]['data']['pid'] === $pid);
