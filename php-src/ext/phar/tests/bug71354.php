<?php
$p = new PharData(__DIR__."/bug71354.tar");
var_dump($p['aaaa']->getContent());
?>
DONE
