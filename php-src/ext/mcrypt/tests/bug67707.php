<?php
$td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
mcrypt_generic_init($td, 'secret key', NULL);
?>
