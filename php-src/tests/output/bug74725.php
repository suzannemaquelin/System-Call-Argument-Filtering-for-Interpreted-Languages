<?php
ini_set('display_errors', 1);
ini_set('html_errors', 1);
ini_set('default_charset', "Windows-1251");
throw new Exception("\xF2\xE5\xF1\xF2");
// Note to test reader: this file is in Windows-1251 (vim: `:e ++enc=cp1251`)
?>
