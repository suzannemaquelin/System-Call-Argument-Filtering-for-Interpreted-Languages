<?php
	/* Setup socket server */
	$server = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	if (!$server) {
		die('Unable to create AF_INET socket [server]');
	}
	$bound = false;
	for($port = 31337; $port < 31357; ++$port) {
		if (socket_bind($server, '127.0.0.1', $port)) {
			$bound = true;
			break;
		}
	}
	if (!$bound) {
		die("Unable to bind to 127.0.0.1");
	}
	if (!socket_listen($server, 2)) {
		die('Unable to listen on socket');
	}

	/* Connect to it */
	$client = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	if (!$client) {
		die('Unable to create AF_INET socket [client]');
	}
	if (!socket_connect($client, '127.0.0.1', $port)) {
		die('Unable to connect to server socket');
	}

	/* Accept that connection */
	$socket = socket_accept($server);
	if (!$socket) {
		die('Unable to accept connection');
	}

	socket_write($client, "ABCdef123\n");

	$data = socket_read($socket, 10, PHP_BINARY_READ);
	var_dump($data);

	socket_close($client);
	socket_close($socket);
	socket_close($server);
?>
