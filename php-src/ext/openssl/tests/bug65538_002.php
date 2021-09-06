<?php
$clientCtx = stream_context_create(['ssl' => [
    // We don't get any ca list from php.net but it does not matter as we
    // care about the fact that the external stream is not allowed.
    // We can't use http://curl.haxx.se/ca/cacert.pem for this test
    // as it is redirected to https which means the test would depend
    // on system cafile when opening stream.
    'cafile' => 'http://www.php.net',
]]);
file_get_contents('https://github.com', false, $clientCtx);
?>
