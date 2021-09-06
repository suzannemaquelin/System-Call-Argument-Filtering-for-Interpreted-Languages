<?php
$_SERVER = 'foo';
output_add_rewrite_var('bar', 'baz');
?>
<form action="http://example.com/"></form>
===DONE===
