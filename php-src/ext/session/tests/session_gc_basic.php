<?php

ob_start();

/*
 * Prototype : int session_gc(void)
 * Description : Perform GC
 * Source code : ext/session/session.c
 */

echo "*** Testing session_gc() : basic functionality ***\n";

var_dump(session_gc());

var_dump(session_start());
var_dump(session_gc(), session_gc() >= -1);
var_dump(session_destroy());
var_dump(session_id());

echo "Done";
ob_end_flush();
?>
