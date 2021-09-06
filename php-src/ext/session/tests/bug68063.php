<?php
// Empty session ID may happen by browser bugs

// Could also be set with a cookie like "PHPSESSID=; path=/"
session_id('');

// Start the session with empty string should result in new session ID
var_dump(session_start());

// Returns newly created session ID
var_dump(session_id());
?>
