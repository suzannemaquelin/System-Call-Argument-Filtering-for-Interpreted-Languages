<?php
	/* Bind and connect sockets to localhost */
	$localhost = '127.0.0.1';

        /* Setup socket server */
        $server = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        if (!$server) {
                die('Unable to create AF_INET socket [server]');
        }

	$minport = 31337;
	$maxport = 31356;
	$bound = false;
	for($port = $minport; $port <= $maxport; ++$port) {
        	if (socket_bind($server, $localhost, $port)) {
			$bound = true;
			break;
		}
	}
	if (!$bound) {
                die('Unable to bind to '.$localhost);
        }
        if (!socket_listen($server, 2)) {
                die('Unable to listen on socket');
        }

        /* Connect to it */
        $client = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        if (!$client) {
                die('Unable to create AF_INET socket [client]');
        }
        if (!socket_connect($client, $localhost, $port)) {
                die('Unable to connect to server socket');
        }

        /* Accept that connection */
        $socket = socket_accept($server);
        if (!$socket) {
                die('Unable to accept connection');
        }

	if (!socket_getpeername($client, $address, $peerport)) {
	   	die('Unable to retrieve peer name');
	}
        var_dump($address, $port === $peerport);

        socket_close($client);
        socket_close($socket);
        socket_close($server);
?>
