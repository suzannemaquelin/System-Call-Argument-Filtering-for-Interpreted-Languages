<?php
$p = new Phar(__FILE__);
echo decoct(fileperms("phar://" . __FILE__ . "/test.txt")),"\n";
$p["test.txt"]->chmod(0444);
echo decoct(fileperms("phar://" . __FILE__ . "/test.txt")),"\n";
echo "ok\n";
__HALT_COMPILER(); ?>
6                     test.txt   Y�wb   ���E$      <?php __HALT_COMPILER();|zX����?4�v�S{�IT�   GBMB