<?php
try {
Phar::webPhar("test.phar", "/index.php", null, array(), function() { throw new Exception; });
} catch (Exception $e) {
die($e->getMessage() . "\n");
}
echo "oops did not run\n";
var_dump($_ENV, $_SERVER);
__HALT_COMPILER(); ?>
7                  	   index.php   ˤ?W   JVԋ?      <?php
echo "hi";
?? ?¼????g<??0??   GBMB