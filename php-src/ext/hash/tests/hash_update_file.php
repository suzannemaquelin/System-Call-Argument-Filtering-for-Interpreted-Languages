<?php
$ctx = hash_init('md5');
$filePath = __DIR__ . DIRECTORY_SEPARATOR . 'sha1.phpt';
fopen($filePath, "r");
var_dump(hash_update_file($ctx, $filePath));
hash_final($ctx);
?>
