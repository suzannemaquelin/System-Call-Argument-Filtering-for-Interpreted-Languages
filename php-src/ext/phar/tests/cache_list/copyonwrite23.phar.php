<?php
$p = new Phar(__FILE__);
var_dump(isset($p["test.txt"]), isset($p["newname"]));
rename("phar://" . __FILE__ . "/test.txt", "phar://" . __FILE__ . "/newname");
var_dump(isset($p["test.txt"]), isset($p["newname"]));
echo "ok\n";
__HALT_COMPILER(); ?>
5                     newname   Z�wb   ���E�      <?php __HALT_COMPILER();�=ό�W�gp���`�,�`\   GBMB