<?php

class aaa extends DatePeriod {
	public function __construct() { }
}

$start=new DateTime( '2012-08-01' );

foreach (new aaa($start) as $y) {
	$a=$key;
}

?>
==DONE==
