<?php
$phar = new Phar(__FILE__);
echo $phar["test.txt"]->getContent();
$phar["test.txt"] = "changed
";
echo $phar["test.txt"]->getContent();
echo "ok\n";
__HALT_COMPILER(); ?>
H              	   s:2:"hi";   test.txt   X?wb   ??o?  	   s:2:"hi";changed
]C?????W??7h??L?y_?   GBMB