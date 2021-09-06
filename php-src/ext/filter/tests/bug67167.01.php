<?php
var_dump(filter_var(
    new \StdClass(),
    FILTER_VALIDATE_BOOLEAN,
    FILTER_NULL_ON_FAILURE
));
