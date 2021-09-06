<?php
$gid = posix_getgid();
$name = posix_getgrgid($gid)['name'];
$info = posix_getgrnam($name);
var_dump(is_array($info));
?>
===DONE===
