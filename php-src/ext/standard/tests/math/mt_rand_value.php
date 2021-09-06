<?php

mt_srand(12345678, MT_RAND_PHP);

for ($i=0; $i<16; $i++) {
    echo mt_rand().PHP_EOL;
}
echo PHP_EOL;

$x = 0;
for ($i=0; $i<1024; $i++) {
    $x ^= mt_rand();
}
echo $x.PHP_EOL;
echo PHP_EOL;

mt_srand(12345678 /*, MT_RAND_MT19937 */);

for ($i=0; $i<16; $i++) {
    echo mt_rand().PHP_EOL;
}
echo PHP_EOL;

$x = 0;
for ($i=0; $i<1024; $i++) {
    $x ^= mt_rand();
}
echo $x.PHP_EOL;

/*
 * Note that the output will be different from the original mt19937ar.c,
 * because PHP's implementation contains a bug. Thus, this test actually
 * checks to make sure that PHP's behaviour is wrong, but consistently so.
 */

?>
