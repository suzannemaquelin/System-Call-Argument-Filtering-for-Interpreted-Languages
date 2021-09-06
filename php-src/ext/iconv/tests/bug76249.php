<?php
$fh = fopen('php://memory', 'rw');
fwrite($fh, "abc");
rewind($fh);
if (false === @stream_filter_append($fh, 'convert.iconv.ucs-2/utf8//IGNORE', STREAM_FILTER_READ, [])) {
	stream_filter_append($fh, 'convert.iconv.ucs-2/utf-8//IGNORE', STREAM_FILTER_READ, []);
}
$a = stream_get_contents($fh);
var_dump(strlen($a));
?>
DONE
