<?php
set_include_path("phar://" . __FILE__);
try {
Phar::webPhar("test.phar", "/start/index.php");
} catch (Exception $e) {
die($e->getMessage() . "\n");
}
echo "oops did not run\n";
var_dump($_ENV, $_SERVER);
__HALT_COMPILER(); ?>
?                     start/index.php9   !?H9   HٗN?         start/another.php>   !?H>   |
???         another.php   !?H   b????      <?php
echo "start/index.php\n";
include "./another.php";
<?php
echo "start/another.php\n";
include "../another.php";
?><?php
echo "another.php\n";
?>{??a?1?K??TIf??T?*   GBMB