<?php
$p = new Phar(__FILE__);
var_dump($p->getAlias());
$p2 = new Phar(__FILE__);
$p->setAlias("hi");
echo $p2->getAlias(),"\n";
echo "ok\n";
__HALT_COMPILER(); ?>
8             hi       test.txt   [?wb   zzo??      hi
??!?^???w?????   GBMB