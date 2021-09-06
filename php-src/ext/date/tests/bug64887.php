<?php
$tests = [
	'+1 ms',
	'-2 msec',
	'+3 msecs',
	'-4 millisecond',
	'+5 milliseconds',

	'-6 usec',
	'+7 usecs',
	'-8 microsecond',
	'+9 microseconds',
	'-10 µs',
	'+11 µsec',
	'-12 µsecs',

	'+8 msec -2 µsec',
];

$datetime = new DateTimeImmutable( "2016-10-07 13:25:50" );

foreach ( $tests as $test )
{
	echo $datetime->modify( $test )->format( 'Y-m-d H:i:s.u' ), "\n";
}

?>
