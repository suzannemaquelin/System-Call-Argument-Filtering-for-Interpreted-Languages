<?php

/**
 * This test uses the openssl binary directly to initiate renegotiation. At this time it's not
 * possible renegotiate the TLS handshake in PHP userland, so using the openssl s_client binary
 * command is the only feasible way to test renegotiation limiting functionality. It's not an ideal
 * solution, but it's really the only way to get test coverage on the rate-limiting functionality
 * given current limitations.
 */

$serverCode = <<<'CODE'
    $printed = false;
    $serverUri = "ssl://127.0.0.1:64321";
    $serverFlags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;
    $serverCtx = stream_context_create(['ssl' => [
        'local_cert' => __DIR__ . '/bug54992.pem',
        'reneg_limit' => 0,
        'reneg_window' => 30,
        'reneg_limit_callback' => function($stream) use (&$printed) {
            if (!$printed) {
                $printed = true;
                var_dump($stream);
            }
        }
    ]]);

    $server = stream_socket_server($serverUri, $errno, $errstr, $serverFlags, $serverCtx);
    phpt_notify();

    $clients = [];
    while (1) {
        $r = array_merge([$server], $clients);
        $w = $e = [];

        stream_select($r, $w, $e, $timeout=42);

        foreach ($r as $sock) {
            if ($sock === $server && ($client = stream_socket_accept($server, $timeout = 42))) {
                $clientId = (int) $client;
                $clients[$clientId] = $client;
            } elseif ($sock !== $server) {
                $clientId = (int) $sock;
                $buffer = fread($sock, 1024);
                if (strlen($buffer)) {
                    continue;
                } elseif (!is_resource($sock) || feof($sock)) {
                    unset($clients[$clientId]);
                    break 2;
                }
            }
        }
    }
CODE;

$clientCode = <<<'CODE'
    $cmd = 'openssl s_client -connect 127.0.0.1:64321';
    $descriptorSpec = [["pipe", "r"], ["pipe", "w"], ["pipe", "w"]];
    $process = proc_open($cmd, $descriptorSpec, $pipes);

    list($stdin, $stdout, $stderr) = $pipes;

    // Trigger renegotiation twice
    // Server settings only allow one per second (should result in disconnection)
    fwrite($stdin, "R\nR\nR\nR\n");

    $lines = [];
    while(!feof($stderr)) {
        fgets($stderr);
    }

    fclose($stdin);
    fclose($stdout);
    fclose($stderr);
    proc_terminate($process);
CODE;

include 'ServerClientTestCase.inc';
ServerClientTestCase::getInstance()->run($serverCode, $clientCode);
?>
