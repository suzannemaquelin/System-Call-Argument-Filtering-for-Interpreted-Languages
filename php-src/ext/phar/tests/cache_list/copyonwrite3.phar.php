<?php
clearstatcache();
var_dump(file_exists("phar://" . __FILE__ . "/test"), is_dir("phar://" . __FILE__ . "/test"));
rmdir("phar://" . __FILE__ . "/test");
clearstatcache();
var_dump(file_exists("phar://" . __FILE__ . "/test"), is_dir("phar://" . __FILE__ . "/test"));
echo "ok\n";
__HALT_COMPILER(); ?>
H              	   s:2:"hi";   test.txt   Z?wb   zzo??  	   s:2:"hi";hi
0?@Dq?؋Y?V?eM??S$G   GBMB