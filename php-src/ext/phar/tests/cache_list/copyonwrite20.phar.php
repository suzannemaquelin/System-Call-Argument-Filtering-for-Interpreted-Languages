<?php
$p = new Phar(__FILE__);
var_dump($p["test.txt"]->getMetadata());
$p["test.txt"]->delMetadata();
var_dump($p["test.txt"]->getMetadata());
echo "ok\n";
__HALT_COMPILER(); ?>
6                     test.txt   Z?wb   ???E?      <?php __HALT_COMPILER();?c??	0H2.?f?Դ?XO
   GBMB