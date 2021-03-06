<?php
/* Prototype  : int DateTimeZone::getOffset  ( DateTime $datetime  )
 * Description: Returns the timezone offset from GMT
 * Source code: ext/date/php_date.c
 * Alias to functions: timezone_offset_get()
 */

echo "*** Testing DateTimeZone::getOffset() : basic functionality ***\n";

//Set the default time zone
date_default_timezone_set("GMT");

$tz1 = new DateTimeZone("Europe/London");
$date = new DateTime("GMT");
var_dump( $tz1->getOffset($date) );

$tz2 = new DateTimeZone("America/New_York");
var_dump( $tz2->getOffset($date) );

$tz3 = new DateTimeZone("America/Los_Angeles");
var_dump( $tz3->getOffset($date) );

?>
===DONE===
