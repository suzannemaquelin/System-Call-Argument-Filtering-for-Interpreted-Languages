<?php

$sRegex = "/([A-Z]|[a-z]|[0-9]| |Ñ|ñ|!|&quot;|%|&amp;|'|´|-|:|;|>|=|&lt;|@|_|,|\{|\}|`|~|á|é|í|ó|ú|Á|É|Í|Ó|Ú|ü|Ü){1,300}/";
$sTest = "Hello world";

var_dump(preg_match($sRegex, $sTest));
var_dump(preg_last_error() === \PREG_INTERNAL_ERROR);
?>
