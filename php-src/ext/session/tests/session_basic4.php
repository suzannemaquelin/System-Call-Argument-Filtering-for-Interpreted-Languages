<?php

ob_start();

/*
 * Prototype : session.use_trans_sid=1
 * Description : Test basic functionality.
 * Source code : ext/session/session.c
 */

echo "*** Testing basic session functionality : variation4 use_trans_sid ***\n";

echo "*** Test trans sid ***\n";
output_add_rewrite_var('testvar1','testvalue1');

session_id('test1');
session_start();

echo '
<a href="/">
<form action="" method="post">
</form>
';

session_commit();

output_add_rewrite_var('testvar2','testvalue2');

session_id('test2');
session_start();
echo '
<a href="/">
<form action="" method="post">
</form>
';
