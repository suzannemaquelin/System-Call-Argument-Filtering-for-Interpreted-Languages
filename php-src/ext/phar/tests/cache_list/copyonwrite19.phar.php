<?php
$p = new Phar(__FILE__);
var_dump($p["test.txt"]->getMetadata());
$p["test.txt"]->setMetadata("hi2");
var_dump($p["test.txt"]->getMetadata());
echo "ok\n";
__HALT_COMPILER(); ?>
@                     test.txt   Z�wb   ���E�  
   s:3:"hi2";<?php __HALT_COMPILER();�)O�{����,��r��l-   GBMB