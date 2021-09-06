<?php
$timezone = "Europe/Zurich\0Foo";
var_dump(timezone_open($timezone));
var_dump(new DateTimeZone($timezone));
?>
