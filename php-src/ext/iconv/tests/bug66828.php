<?php
$preferences = array(
    "input-charset" => "ISO-8859-1",
    "output-charset" => "UTF-8",
    "line-length" => 76,
    "line-break-chars" => "\n",
    "scheme" => "Q"
);
var_dump(iconv_mime_encode("Subject", "Test Test Test Test Test Test Test Test", $preferences));
?>
===DONE===
