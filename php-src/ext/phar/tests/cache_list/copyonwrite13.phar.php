<?php
$p = new Phar(__FILE__);
var_dump($p["test.txt"]->isCompressed());
$p2 = new Phar(__FILE__);
$p->compressFiles(Phar::GZ);
var_dump($p["test.txt"]->isCompressed());
echo "ok\n";
__HALT_COMPILER(); ?>
6                    test.txt   Y?wb   ???E?      ??/?(P???p?	?w????q?д 8??XI??????[Y??aEv   GBMB