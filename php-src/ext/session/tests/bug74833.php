<?php

ob_start();

session_start();
session_regenerate_id();
$c = get_defined_constants(true);
/* Ensure the SID constant has correct module number. */
var_dump(isset($c['session']['SID']));

ob_end_flush();
?>
==DONE==
