<?php
	ob_start();
// Common setting
ini_set('url_rewriter.hosts', 'php.net,www.php.net');
ini_set('session.trans_sid_hosts', 'php.net,www.php.net');
ini_set('session.use_only_cookies', 0);
ini_set('session.use_cookies', 0);
ini_set('session.use_strict_mode', 0);
session_id('testid');

output_add_rewrite_var('<name>', '<value>');
?>
Without session
<a href=""> </a>
<a href="./foo.php"> </a>
<a href="//php.net/foo.php"> </a>
<a href="http://php.net/foo.php"> </a>
<a href="bad://php.net/foo.php"> </a>
<a href="//www.php.net/foo.php"> </a>

<form method="get"> </form>
<form action="./foo.php" method="get">
<form action="//php.net/bar.php" method="get">
<form action="http://php.net/bar.php" method="get">
<form action="bad://php.net/bar.php" method="get">
<form action="//www.php.net/bar.php" method="get">

<?php
ini_set('session.use_trans_sid', 0);
session_start();
output_add_rewrite_var('<name>', '<value>');
?>
Test use_trans_sid=0
<a href=""> </a>
<a href="./foo.php"> </a>
<a href="//php.net/foo.php"> </a>
<a href="http://php.net/foo.php"> </a>
<a href="bad://php.net/foo.php"> </a>
<a href="//www.php.net/foo.php"> </a>

<form method="get"> </form>
<form action="./foo.php" method="get"> </form>
<form action="//php.net/bar.php" method="get"> </form>
<form action="http://php.net/bar.php" method="get"> </form>
<form action="bad://php.net/bar.php" method="get"> </form>
<form action="//www.php.net/bar.php" method="get"> </form>

<?php
session_commit();
ini_set('session.use_trans_sid', 1);
output_reset_rewrite_vars();
session_start();
output_add_rewrite_var('<NAME>', '<VALUE>');
?>
Test use_trans_sid=1
<a href=""> </a>
<a href="./foo.php"> </a>
<a href="//php.net/foo.php"> </a>
<a href="http://php.net/foo.php"> </a>
<a href="bad://php.net/foo.php"> </a>
<a href="//www.php.net/foo.php"> </a>

<form method="get"> </form>
<form action="./foo.php" method="get"> </form>
<form action="//php.net/bar.php" method="get"> </form>
<form action="http://php.net/bar.php" method="get"> </form>
<form action="bad://php.net/bar.php" method="get"> </form>
<form action="//www.php.net/bar.php" method="get"> </form>
