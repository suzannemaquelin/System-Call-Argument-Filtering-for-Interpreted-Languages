<?php
$phar = new Phar(__FILE__);
var_dump($phar->getMetadata());
mkdir("phar://" . __FILE__ . "/test");
var_dump(is_dir("phar://" . __FILE__ . "/test"));
$phar2 = new Phar(__FILE__);
var_dump($phar2->getMetadata());
var_dump(isset($phar["test"]));
var_dump(isset($phar2["test"]));
echo "ok\n";
__HALT_COMPILER(); ?>
i             	   s:2:"hi";   test.txt   Z?wb   zzo??  	   s:2:"hi";   test/    Z?wb        ?      hi
>M?"Y?&u?IpU?j?z?   GBMB