<?php
$dummy = unserialize('O:10:"SoapClient":3:{s:3:"uri";s:1:"X";s:8:"location";s:22:"http://localhost/a.xml";s:17:"__default_headers";a:1:{i:1;s:1337:"'.str_repeat("X", 1337).'";}}');
try {
	var_dump($dummy->notexisting());
} catch(Exception $e) {
	var_dump($e->getMessage());
	var_dump(get_class($e));
}
?>
