<?php
Phar::mungServer(array("PHP_SELF", "SCRIPT_NAME", "SCRIPT_FILENAME", "REQUEST_URI"));
Phar::webPhar();
echo "oops did not run\n";
var_dump($_ENV, $_SERVER);
__HALT_COMPILER(); ?>
7                  	   index.php;  ??kJ;  W?R?      <?php
var_dump($_SERVER["PHP_SELF"]);
var_dump($_SERVER[b"SCRIPT_NAME"]);
var_dump($_SERVER[b"SCRIPT_FILENAME"]);
var_dump($_SERVER[b"REQUEST_URI"]);
var_dump($_SERVER[b"PHAR_PHP_SELF"]);
var_dump($_SERVER[b"PHAR_SCRIPT_NAME"]);
var_dump($_SERVER[b"PHAR_SCRIPT_FILENAME"]);
var_dump($_SERVER[b"PHAR_REQUEST_URI"]);
c??j?Fgs?_q??   GBMB