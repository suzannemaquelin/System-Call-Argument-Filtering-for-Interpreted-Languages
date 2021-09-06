<?php

$date = mktime(17, 52, 13, 4, 30, 2016);
var_dump(date(\DateTime::RFC7231, $date));

?>
