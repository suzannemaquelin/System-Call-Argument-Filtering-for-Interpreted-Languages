<?php

$sock0 = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($sock0, '0.0.0.0', 58380);
$stream0 = socket_export_stream($sock0);
leak_variable($stream0, true);

$sock1 = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($sock1, '0.0.0.0', 58381);
$stream1 = socket_export_stream($sock1);
leak_variable($sock1, true);

echo "Done.\n";
