<?php

$headers = <<< HEADERS
X-Header-One: H4sIAAAAAAAAA+NgFlsCAAA=
X-Header-Two: XtLePq6GTMn8G68F0
HEADERS;
var_dump(iconv_mime_decode_headers($headers, ICONV_MIME_DECODE_CONTINUE_ON_ERROR));

$headers = <<< HEADERS
X-Header-One: =
X-Header-Two: XtLePq6GTMn8G68F0
HEADERS;
var_dump(iconv_mime_decode_headers($headers, ICONV_MIME_DECODE_STRICT));
?>
===DONE===
