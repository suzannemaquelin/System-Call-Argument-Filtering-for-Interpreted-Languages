<?php
$domains = array('yahoo.co.jp', 'yahoo.com', 'es.yahoo.com', 'fr.yahoo.com', 'it.yahoo.com');
foreach ($domains as $domain) {
    if (getmxrr($domain, $hosts, $weights)) {
        echo "Hosts: " . count($hosts) . ", weights: " . count($weights) . "\n";
    }
}
?>
