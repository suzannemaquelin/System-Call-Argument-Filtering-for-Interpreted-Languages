<?php
//-=-=-=-

try {
    $bytes = random_bytes();
} catch (TypeError $e) {
    echo $e->getMessage().PHP_EOL;
}

try {
    $bytes = random_bytes(0);
} catch (Error $e) {
    echo $e->getMessage().PHP_EOL;
}

?>
