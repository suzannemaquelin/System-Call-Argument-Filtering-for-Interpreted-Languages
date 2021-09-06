<?php
$input = "AAAAAAAA";
$param = array('blocks' => $input);

$fp = fopen('testfile', 'w');
stream_filter_append($fp, 'bzip2.compress', STREAM_FILTER_WRITE, $param);
fclose($fp);
?>
