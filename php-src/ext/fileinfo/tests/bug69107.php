<?php
$finfo = new finfo(FILEINFO_MIME_TYPE);

var_dump($finfo->buffer("<?php\nclass A{}"));
var_dump($finfo->buffer("<?php class A{}"));
var_dump($finfo->buffer("<?php\tclass A{}"));
var_dump($finfo->buffer("<?php\n\rclass A{}"));
?>
===DONE===
