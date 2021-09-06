<?php
/*
#vim: set fileencoding=utf-8
#vim: set encoding=utf-8
*/

var_dump(putenv('FOO=啊'), getenv("FOO"));
var_dump(putenv('FOO=啊啊'), getenv("FOO"));
var_dump(putenv('FOO=啊啊啊'), getenv("FOO"));
var_dump(putenv('FOO=啊啊啊啊'), getenv("FOO"));

var_dump(putenv('FOO=啊a'), getenv("FOO"));
var_dump(putenv('FOO=啊a啊'), getenv("FOO"));
var_dump(putenv('FOO=啊a啊a'), getenv("FOO"));
var_dump(putenv('FOO=啊a啊a啊'), getenv("FOO"));
var_dump(putenv('FOO=啊a啊啊'), getenv("FOO"));
var_dump(putenv('FOO=啊a啊啊啊'), getenv("FOO"));
var_dump(putenv('FOO=啊a啊啊啊啊'), getenv("FOO"));

?>
===DONE===
