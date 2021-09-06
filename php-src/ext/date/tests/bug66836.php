<?php
foreach (['-1', '-86400', '-1000000'] as $timestamp) {
    $dt = DateTime::createFromFormat('U', $timestamp);
    var_dump($dt->format('U') === $timestamp);
}
?>
