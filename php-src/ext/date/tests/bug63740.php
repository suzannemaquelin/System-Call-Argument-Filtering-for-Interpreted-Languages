<?php
$dates = [
	'2015-07-04',
	'2015-07-05',
	'2015-07-06',
	'2015-07-07',
	'2015-07-08',
	'2015-07-09',
	'2015-07-10',
	'2015-07-11',
	'2015-07-12',
	'2015-07-13',
	'2015-07-14',
];

foreach ( $dates as $date )
{
	$dt = new DateTimeImmutable( "$date 00:00 UTC" );

	echo $dt->format( "D Y-m-d H:i" ), " → ";

	$dtn = $dt->modify( "this week" );

	echo $dtn->format( "D Y-m-d H:i" ), "\n";
}
?>
