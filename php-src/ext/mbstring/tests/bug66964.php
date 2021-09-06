<?php
$a[] = &$a;
var_dump(mb_convert_variables('utf-8', 'auto', $a));
var_dump(mb_convert_variables('utf-8', 'utf-8', $a));

unset($a);
$a[] = '日本語テキスト';
$a[] = '日本語テキスト';
$a[] = '日本語テキスト';
$a[] = '日本語テキスト';
var_dump(mb_convert_variables('utf-8', 'utf-8', $a), $a);

$a[] = &$a;
var_dump(mb_convert_variables('utf-8', 'utf-8', $a), $a);

?>
