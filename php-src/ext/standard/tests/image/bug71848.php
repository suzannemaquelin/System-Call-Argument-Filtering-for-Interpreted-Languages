<?php
var_dump(getimagesize(__DIR__ . '/bug71848.jpg', $info));
var_dump(array_keys($info));
?>
===DONE===
