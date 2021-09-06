<?php
session_start();
$sess = 'O:9:"Exception":2:{s:7:"'."\0".'*'."\0".'file";R:1;}';
session_decode($sess);
var_dump($_SESSION);
?>
