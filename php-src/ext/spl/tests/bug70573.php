<?php
$q1 = new SplPriorityQueue();
$a = 1;
$q1->insert([$a], 1);
$q1->insert([$a], 2);
$q2 = clone $q1;
echo "ok\n";
?>
