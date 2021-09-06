<?php
//-=-=-=-

try {
    $randomInt = random_int();
} catch (TypeError $e) {
    echo $e->getMessage().PHP_EOL;
}

try {
    $randomInt = random_int(42);
} catch (TypeError $e) {
    echo $e->getMessage().PHP_EOL;
}

try {
    $randomInt = random_int(42,0);
} catch (Error $e) {
    echo $e->getMessage().PHP_EOL;
}

?>
