<?php
mb_http_output("EUC-JP");
ob_start();
ob_start('mb_output_handler');
echo "ใในใ";
ob_end_flush();
var_dump(bin2hex(ob_get_clean()));
?>
