<?php
mb_http_output("EUC-JP");
ini_set('mbstring.http_output_conv_mimetypes', 'application');
header("Content-Type: text/html");
ob_start();
ob_start('mb_output_handler');
echo "ใในใ";
ob_end_flush();
var_dump(bin2hex(ob_get_clean()));
?>
