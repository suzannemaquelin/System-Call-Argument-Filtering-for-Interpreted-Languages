<?php
var_dump(filter_var(
    null,
    FILTER_VALIDATE_BOOLEAN,
    FILTER_NULL_ON_FAILURE
));
