<?php
$p = new Phar(__FILE__);
var_dump(isset($p["newname"]));
$fp = fopen("phar://" . __FILE__ . "/newname", "w");
fwrite($fp, b"hi");
fclose($fp);
var_dump(isset($p["newname"]));
echo "ok\n";
__HALT_COMPILER(); ?>
Y                     test.txt   Z?wb   ???E?         newname   Z?wb   ?*?ض      <?php __HALT_COMPILER();hi?????@$?߁?^5)?>?   GBMB