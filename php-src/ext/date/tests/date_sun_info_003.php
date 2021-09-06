<?php
date_default_timezone_set('America/Sao_Paulo');
$sun_info = date_sun_info(strtotime("2015-01-12 00:00:00 UTC"), 89.00, 1.00);
foreach ($sun_info as $key => $elem ) {
    echo "$key: " . date("H:i:s", $elem) . "\n";
}

echo "\n";

$sun_info = date_sun_info(strtotime("2015-09-12 00:00:00 UTC"), 89.00, 1.00);
foreach ($sun_info as $key => $elem ) {
    echo "$key: " . date("H:i:s", $elem) . "\n";
}

echo "Done\n";
?>
