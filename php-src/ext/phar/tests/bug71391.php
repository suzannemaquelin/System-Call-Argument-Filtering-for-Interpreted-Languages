<?php
// duplicate since the tar will change
copy(__DIR__."/bug71391.tar", __DIR__."/bug71391.test.tar");
$p = new PharData(__DIR__."/bug71391.test.tar");
$p->delMetaData();
?>
DONE
