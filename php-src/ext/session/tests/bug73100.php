<?php
ob_start();
var_dump(session_start());
session_module_name("user");
var_dump(session_destroy());
?>
===DONE===
