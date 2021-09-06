<?php
var_dump(count($_ENV['PATH']) > 0);
var_dump(count(filter_input(INPUT_ENV, 'PATH')) > 0);
?>
