<?php
$d = dirname(__FILE__);
$Files2Report =
 [
  str_pad ($d . '/' . str_repeat (str_pad ('bug75679_path_259_characters_long_', 100, '_') . '/', 1), 259, '_') => [],
  str_pad ($d . '/' . str_repeat (str_pad ('bug75679_path_260_characters_long_', 100, '_') . '/', 1), 260, '_') => [],
  str_pad ($d . '/' . str_repeat (str_pad ('bug75679_path_261_characters_long_', 100, '_') . '/', 1), 261, '_') => [],
 ];
foreach ($Files2Report as $file => &$Report)
 {
  $Report = ['strlen' => strlen ($file), 'result' => 'nok'];

  if (! is_dir (dirname ($file))) mkdir (dirname ($file), 0777, true);
  if (copy (__FILE__, $file) && is_file ($file))
   {
    $Report['result'] = 'ok';
   }

  print_r ($Report);
 }


?>
==DONE==
