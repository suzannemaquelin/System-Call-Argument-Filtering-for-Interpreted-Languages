<?php
$line  = str_repeat(' ',20); $value ='03'; $pos=0; $len='2';
$line = substr_replace($line,$value,$pos,$len);
echo "[$line]\n";
?>
