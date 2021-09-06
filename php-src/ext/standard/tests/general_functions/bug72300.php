<?php

var_dump(ignore_user_abort(true));
var_dump(ignore_user_abort());
var_dump(ini_get("ignore_user_abort"));
var_dump(ignore_user_abort(false));
var_dump(ignore_user_abort());
var_dump(ini_get("ignore_user_abort"));

?>
