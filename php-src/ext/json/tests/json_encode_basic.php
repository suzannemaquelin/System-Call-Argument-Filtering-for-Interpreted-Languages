<?php
echo "*** Testing json_encode() : basic functionality ***\n";

//get an unset variable
$unset_var = 10;
unset ($unset_var);

// get a resource variable
$fp = fopen(__FILE__, "r");

// get an object
class sample  {
}

$obj = new sample();
$obj->MyInt = 99;
$obj->MyFloat = 123.45;
$obj->MyBool = true;
$obj->MyNull = null;
$obj->MyString = "Hello World";

// array with different values for $string
$inputs =  array (
	// integers
	0,
	123,
	-123,
	 2147483647,
	-2147483648,

	// floats
	123.456,
	1.23E3,
	-1.23E3,

	// boolean
	TRUE,
	true,
	FALSE,
	false,

	// NULL
	NULL,
	null,

	// strings
	"abc",
	'abc',
	"Hello\t\tWorld\n",

	// arrays
	array(),
	array(1,2,3,4,5),
	array(1 => "Sun", 2 => "Mon", 3 => "Tue", 4 => "Wed", 5 => "Thur", 6 => "Fri", 7 => "Sat"),
	array("Jan" => 31, "Feb" => 29, "Mar" => 31, "April" => 30, "May" => 31, "June" => 30),

	// empty data
	"",
	'',

	// undefined data
	@$undefined_var,

	// unset data
	@$unset_var,

	// resource variable
	$fp,

	// object variable
	$obj

);

// loop through with each element of the $inputs array to test json_encode() function
$count = 1;
foreach($inputs as $input) {
	echo "-- Iteration $count --\n";
	var_dump(json_encode($input));
	$count ++;
}

?>
===Done===
