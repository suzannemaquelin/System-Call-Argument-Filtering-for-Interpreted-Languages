<?php

$ssl=true;
require __DIR__ . "/../../../ftp/tests/server.inc";

$path="ftps://127.0.0.1:" . $port."/";

$context = stream_context_create(array('ssl' => array('cafile' =>  __DIR__ . '/../../../ftp/tests/cert.pem')));

$ds=opendir($path, $context);
var_dump($ds);
while ($fn=readdir($ds)) {
      var_dump($fn);
}
?>
==DONE==
