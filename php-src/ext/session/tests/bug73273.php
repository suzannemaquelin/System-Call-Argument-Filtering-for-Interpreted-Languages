<?php
session_start();
$_SESSION['test'] = true;
$var = $_SESSION;
session_unset();
var_dump($var);
?>
