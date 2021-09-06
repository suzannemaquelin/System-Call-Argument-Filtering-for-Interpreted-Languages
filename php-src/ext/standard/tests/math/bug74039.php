<?php

var_dump(is_finite(INF));
var_dump(is_infinite(INF));
var_dump(is_nan(INF));

var_dump(is_finite(-INF));
var_dump(is_infinite(-INF));
var_dump(is_nan(-INF));

var_dump(is_finite(NAN));
var_dump(is_infinite(NAN));
var_dump(is_nan(NAN));

?>
