<?php
ob_start();

ini_set('session.use_strict_mode', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 0);
session_start();
var_dump(session_id(), SID);
session_destroy();

ini_set('session.use_strict_mode', 0);
ini_set('session.use_cookies', 0);
ini_set('session.use_only_cookies', 0);
session_start();
var_dump(session_id(), SID);
session_destroy();
?>
