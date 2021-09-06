<?php // $Id$

$test1 = str_repeat("\xFF", 40);
$test2 = str_repeat("\x00", 40);
echo hash('gost-crypto', $test1),
     "\n",
     hash('gost', $test1),
     "\n",
     hash('gost-crypto', $test2),
     "\n",
     hash('gost', $test2),
     "\n",
     hash('gost-crypto', ''),
     "\n",
     hash('gost', '')
    ;
?>
