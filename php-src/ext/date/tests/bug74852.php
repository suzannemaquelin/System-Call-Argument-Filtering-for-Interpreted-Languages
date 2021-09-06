<?php

$interval = new DateInterval('P2D');
var_dump(property_exists($interval,'abcde'));
var_dump(isset($interval->abcde));
var_dump($interval->abcde);

?>
