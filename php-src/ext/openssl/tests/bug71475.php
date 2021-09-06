<?php
$_ = str_repeat("A", 512);
openssl_seal($_, $_, $_, array_fill(0,64,0));
?>
DONE
