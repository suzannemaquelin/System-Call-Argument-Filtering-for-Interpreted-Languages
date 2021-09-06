<?php
$p = new PharData(__DIR__."/bug71488.tar");
$newp = $p->decompress("test");
?>

DONE
