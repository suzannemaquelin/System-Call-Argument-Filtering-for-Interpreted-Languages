<?php
echo "*** Testing hexdec() : basic functionality ***\n";

$values = array(0x123abc,
				0x789DEF,
				0x7FFFFFFF,
				0x80000000,
				'0x123abc',
				'0x789DEF',
				'0x7FFFFFFF',
				'0x80000000',
				'0x123XYZABC',
				311015,
				'311015',
				31101.3,
				31.1013e5,
				011237,
				'011237',
				true,
				false,
				null);

foreach($values as $value) {
	echo "\n-- hexdec $value --\n";
	var_dump(hexdec($value));
};

?>
===Done===
