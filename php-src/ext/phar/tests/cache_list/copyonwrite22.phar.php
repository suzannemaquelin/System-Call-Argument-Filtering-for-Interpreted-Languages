<?php
$p = new Phar(__FILE__);
var_dump($p["test.txt"]->isCompressed());
$p["test.txt"]->decompress();
var_dump($p["test.txt"]->isCompressed());
echo "ok\n";
__HALT_COMPILER(); ?>
6                     test.txt   Z�wb   T$g��      ��/�(P���p�	�w����q�д����ikq�L���4�P�%   GBMB