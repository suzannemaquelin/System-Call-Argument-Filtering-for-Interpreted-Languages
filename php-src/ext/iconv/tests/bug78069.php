<?php
$hdr = iconv_mime_decode_headers(file_get_contents(__DIR__ . "/bug78069.data"),2);
var_dump(count($hdr));
?>
DONE
