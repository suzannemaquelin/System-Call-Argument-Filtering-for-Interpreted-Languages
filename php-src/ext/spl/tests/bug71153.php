<?php

$n = 200000;

for ($i = 0; $i < $n; ++$i) {
    foreach (new ArrayIterator([]) as $v) {}
}

echo "done\n";

?>
