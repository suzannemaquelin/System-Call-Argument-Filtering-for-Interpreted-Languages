<?php
//https://tools.ietf.org/html/rfc6890#section-2.1

$privateRanges = array();
// 10.0.0.0/8
$privateRanges['10.0.0.0/8'] = array('10.0.0.0', '10.255.255.255');

// 169.254.0.0/16
$privateRanges['168.254.0.0/16'] = array('169.254.0.0', '169.254.255.255');

// 172.16.0.0/12
$privateRanges['172.16.0.0/12'] = array('172.16.0.0', '172.31.0.0');

// 192.168.0.0/16
$privateRanges['192.168.0.0/16'] = array('192.168.0.0', '192.168.255.255');

foreach ($privateRanges as $key => $range) {
	list($min, $max) = $range;
	var_dump($key);
	var_dump(filter_var($min, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE));
	var_dump(filter_var($max, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE));
}

$reservedRanges = array();

// 0.0.0.0/8
$reservedRanges['0.0.0.0/8'] = array('0.0.0.0', '0.255.255.255');

// 10.0.0.0/8
$reservedRanges['10.0.0.0/8'] = array('10.0.0.0', '10.255.255.255');

// 100.64.0.0/10
$reservedRanges['10.64.0.0/10'] = array('100.64.0.0', '100.127.255.255');

// 127.0.0.0/8
$reservedRanges['127.0.0.0/8'] = array('127.0.0.0', '127.255.255.255');

// 169.254.0.0/16
$reservedRanges['169.254.0.0/16'] = array('169.254.0.0', '169.254.255.255');

// 172.16.0.0/12
$reservedRanges['172.16.0.0/12'] = array('172.16.0.0', '172.31.0.0');

// 192.0.0.0/24
$reservedRanges['192.0.0.0/24'] = array('192.0.0.0', '192.0.0.255');

// 192.0.0.0/29
$reservedRanges['192.0.0.0/29'] = array('192.0.0.0', '192.0.0.7');

// 192.0.2.0/24
$reservedRanges['192.0.2.0/24'] = array('192.0.2.0', '192.0.2.255');

// 198.18.0.0/15
$reservedRanges['198.18.0.0/15'] = array('198.18.0.0', '198.19.255.255');

// 198.51.100.0/24
$reservedRanges['198.51.100.0/24'] = array('198.51.100.0', '198.51.100.255');

// 192.88.99.0/24
$reservedRanges['192.88.99.0/24'] = array('192.88.99.0', '192.88.99.255');

// 192.168.0.0/16
$reservedRanges['192.168.0.0/16'] = array('192.168.0.0', '192.168.255.255');

// 203.0.113.0/24
$reservedRanges['203.0.113.0/24'] = array('203.0.113.0', '203.0.113.255');

// 240.0.0.0/4 + 255.255.255.255/32
$reservedRanges['240.0.0.0/4'] = array('224.0.0.0', '255.255.255.255');

foreach ($reservedRanges as $key => $range) {
	list($min, $max) = $range;
	var_dump($key);
	var_dump(filter_var($min, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE));
	var_dump(filter_var($max, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE));
}
