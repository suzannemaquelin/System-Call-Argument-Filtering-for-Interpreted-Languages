<?php
var_dump(Phar::canCompress(Phar::GZ) == extension_loaded("zlib"));
var_dump(Phar::canCompress(Phar::BZ2) == extension_loaded("bz2"));
?>
===DONE===
