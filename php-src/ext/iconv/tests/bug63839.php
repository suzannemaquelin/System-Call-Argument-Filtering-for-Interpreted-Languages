<?php
$headers = 'From: "xyz" <xyz@xyz.com>
To: <xyz@xyz.com>
Subject: Reply Is? white side-LED =? in Help
Date: Sat, 22 Dec 2012
Message-ID: <006f01cde00e$d9f79da0$8de6d8e0>
MIME-Version: 1.0
Content-Type: multipart/alternative;
	boundary="----=_NextPart_000_0070_01CDE03C.F3AFD9A0"
X-Mailer: Microsoft Office Outlook 12.0
Thread-Index: Ac3gDtcH2huHjzYcQVmFJPPoWjJogA==
Content-Language: en-us

';
var_dump(iconv_mime_decode_headers($headers, ICONV_MIME_DECODE_CONTINUE_ON_ERROR));
var_dump(iconv_mime_decode_headers($headers, ICONV_MIME_DECODE_STRICT));
?>
===DONE===
