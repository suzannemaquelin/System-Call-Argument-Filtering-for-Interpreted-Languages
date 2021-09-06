<?php
$values = Array(
'niceändsimple@example.com',
'véry.çommon@example.com',
'a.lîttle.lengthy.but.fiñe@dept.example.com',
'dîsposable.style.émail.with+symbol@example.com',
'other.émail-with-dash@example.com',
'üser@[IPv6:2001:db8:1ff::a0b:dbd0]',
'"verî.uñusual.@.uñusual.com"@example.com',
'"verî.(),:;<>[]\".VERÎ.\"verî@\ \"verî\".unüsual"@strange.example.com',
'tést@example.com',
'tést.child@example.com',
'tést@xn--exmple-cua.com',
'tést@xn----zfa.xe',
'tést@subexample.wizard',
'tést@[255.255.255.255]',
'tést@[IPv6:2001:0db8:85a3:08d3:1319:8a2e:0370:7344]',
'tést@[IPv6:2001::7344]',
'tést@[IPv6:1111:2222:3333:4444:5555:6666:255.255.255.255]',
'tést+reference@example.com',
'üñîçøðé@example.com',
'"üñîçøðé"@example.com',
'ǅǼ੧ఘⅧ⒇৪@example.com',
);
foreach ($values as $value) {
	var_dump(filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE));
}
echo "Done\n";
?>
