<?php
$infile = dirname(__FILE__).'/bug34704私はガラスを食べられます.jpg';
var_dump(exif_read_data($infile));
?>
===DONE===
