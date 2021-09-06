<?php
/* Normal creation */
$dt = date_create( "2016-10-03 12:47:18.819313" );

$s = serialize( $dt );
echo $s, "\n";

$u = unserialize( $s );
var_dump( $u );
?>
