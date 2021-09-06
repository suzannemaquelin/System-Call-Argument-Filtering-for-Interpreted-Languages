<?php

error_reporting(E_ALL);
ini_set('session.trans_sid_hosts', 'php.net');
$_SERVER['HTTP_HOST'] = 'php.net';

session_id("abtest");
session_start();
?>
<form action="//bad.net/do.php">
<fieldset>
<form action="//php.net/do.php">
<fieldset>
<?php

ob_flush();

ini_set("url_rewriter.tags", "a=href,area=href,frame=src,input=src,form=");

?>
<form action="../do.php">
<fieldset>
<?php

ob_flush();

ini_set("url_rewriter.tags", "a=href,area=href,frame=src,input=src,form=fakeentry");

?>
<form action="/do.php">
<fieldset>
<?php

ob_flush();

ini_set("url_rewriter.tags", "a=href,fieldset=,area=href,frame=src,input=src");

?>
<form action="/foo/do.php">
<fieldset>
<?php

session_destroy();
?>
