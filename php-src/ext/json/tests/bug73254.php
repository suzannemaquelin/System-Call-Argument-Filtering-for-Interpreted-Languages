<?php

echo json_encode([json_encode([1], JSON_PRETTY_PRINT)]), "\n";

$fp = fopen('php://temp', 'r');
$data = ['a' => $fp];
echo json_encode($data), "\n";
echo json_encode([json_encode([1], JSON_PRETTY_PRINT)]), "\n";

?>
