<?php
var_dump(
    filter_var(new stdClass, FILTER_VALIDATE_INT, [
        'options' => ['default' => 2],
    ]),
    filter_var(new stdClass, FILTER_VALIDATE_INT, [
        'options' => ['default' => 2],
        'flags' => FILTER_NULL_ON_FAILURE
    ])
);
?>
===DONE===
