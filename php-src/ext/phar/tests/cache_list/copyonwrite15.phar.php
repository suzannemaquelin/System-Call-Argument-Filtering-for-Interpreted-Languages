<?php
$p = new Phar(__FILE__);
var_dump(isset($p["copied"]));
$p->copy("test.txt","copied");
var_dump(isset($p["copied"]));
echo "ok\n";
__HALT_COMPILER(); ?>
X                     test.txt   Y�wb   ���E�         copied   Y�wb   ���E�      <?php __HALT_COMPILER();<?php __HALT_COMPILER();����k���M4�'wF@   GBMB