<?php
$serverCode = <<<'CODE'
    $flags = STREAM_SERVER_BIND|STREAM_SERVER_LISTEN;
    $ctx = stream_context_create(['ssl' => [
        'local_cert' => __DIR__ . '/streams_crypto_method.pem',
    ]]);

    $server = stream_socket_server('tlsv1.2://127.0.0.1:64321', $errno, $errstr, $flags, $ctx);
    phpt_notify();

    for ($i=0; $i < 3; $i++) {
        @stream_socket_accept($server, 3);
    }
CODE;

$clientCode = <<<'CODE'
    $flags = STREAM_CLIENT_CONNECT;
    $ctx = stream_context_create(['ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]]);

    phpt_wait();

    $client = stream_socket_client("tlsv1.2://127.0.0.1:64321", $errno, $errstr, 3, $flags, $ctx);
    var_dump($client);
    
    $client = @stream_socket_client("sslv3://127.0.0.1:64321", $errno, $errstr, 3, $flags, $ctx);
    var_dump($client);
    
    $client = @stream_socket_client("tlsv1.1://127.0.0.1:64321", $errno, $errstr, 3, $flags, $ctx);
    var_dump($client);
CODE;

include 'ServerClientTestCase.inc';
ServerClientTestCase::getInstance()->run($clientCode, $serverCode);
?>
