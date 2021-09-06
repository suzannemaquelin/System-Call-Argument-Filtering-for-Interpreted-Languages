<?php

$contents = <<<EOS
[agatha.christie]
title = 10 little indians
foo[123] = E_ALL & ~E_DEPRECATED
foo[456] = 123
EOS;

var_dump(parse_ini_string($contents, false, INI_SCANNER_TYPED));

?>
Done
