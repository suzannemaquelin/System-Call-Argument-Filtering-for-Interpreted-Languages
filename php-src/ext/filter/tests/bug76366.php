<?php

#array to filter
$data = ['foo' => 6];

#filter args
$args = [
    'foo'=> [
        'filter' => FILTER_VALIDATE_INT,
        'flags' => FILTER_FORCE_ARRAY
    ]
];

$args['foo']['options'] = [];

#create reference
$options = &$args['foo']['options'];

#set options
$options['min_range'] = 1;
$options['max_range'] = 5;

#show the filter result
var_dump(filter_var_array($data, $args));
?>
