<?php
function usercompare($a,$b) {
  unset($GLOBALS['my_var'][2]);
  return $a <=> $b;
}
$my_var = array(1 => "entry_1",
2 => "entry_2",
3 => "entry_3",
4 => "entry_4",
5 => "entry_5");
usort($my_var, "usercompare");
var_dump($my_var);

?>
