<?php
preg_match_all('/(?J)(?<chr>[ac])(?<num>\d)|(?<chr>[b])/', 'a1bc3', $m, PREG_SET_ORDER);
var_dump($m);

unset($m);
preg_match_all('/(?<chr>[ac])(?<num>\d)|(?<chr>[b])/J', 'a1bc3', $m, PREG_SET_ORDER);
var_dump($m);
?>
