<?php
ob_start();
session_start();

$session = &$_SESSION;

$session['test'] = 1;
session_regenerate_id(false);
$session['test'] = 2;

var_dump($session['test'] === $_SESSION['test']);

$session['test'] = 3;
session_regenerate_id(true);
$session['test'] = 4;

var_dump($session['test'] === $_SESSION['test']);
?>
