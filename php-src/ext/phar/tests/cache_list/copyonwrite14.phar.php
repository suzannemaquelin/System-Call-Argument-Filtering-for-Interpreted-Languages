<?php
$p = new Phar(__FILE__);
var_dump($p["test.txt"]->isCompressed());
$p2 = new Phar(__FILE__);
$p->decompressFiles();
var_dump($p["test.txt"]->isCompressed());
echo "ok\n";
__HALT_COMPILER(); ?>
6                     test.txt   Y�wb   T$g��      ��/�(P���p�	�w����q�д殔��C����Һ��LE߉   GBMB