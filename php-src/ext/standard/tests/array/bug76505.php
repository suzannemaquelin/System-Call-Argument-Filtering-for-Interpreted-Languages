<?php
$array1 = array(
    'k' => array(
        2 => 100,
        98 => 200,
    )
);

$array2 = array(
    'k' => array(
        64 => 300
    )
);

$array3 = array_merge_recursive( $array1, $array2 );

var_dump($array3);
?>
