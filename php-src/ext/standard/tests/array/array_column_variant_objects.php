<?php

class User
{
	public $id, $first_name, $last_name;

	public function __construct($id, $first_name, $last_name)
	{
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
	}
}

function newUser($id, $first_name, $last_name)
{
    $o = new stdClass;
    $o->{0} = $id;
    $o->{1} = $first_name;
    $o->{2} = $last_name;

    return $o;
}

class Something
{
	public function __isset($name)
	{
		return $name == 'first_name';
	}

	public function __get($name)
	{
		return new User(4, 'Jack', 'Sparrow');
	}
}

$records = array(
    newUser(1, 'John', 'Doe'),
    newUser(2, 'Sally', 'Smith'),
    newUser(3, 'Jane', 'Jones'),
    new User(1, 'John', 'Doe'),
    new User(2, 'Sally', 'Smith'),
    new User(3, 'Jane', 'Jones'),
	new Something,
);

echo "*** Testing array_column() : object property fetching (numeric property names) ***\n";

echo "-- first_name column from recordset --\n";
var_dump(array_column($records, 1));

echo "-- id column from recordset --\n";
var_dump(array_column($records, 0));

echo "-- last_name column from recordset, keyed by value from id column --\n";
var_dump(array_column($records, 2, 0));

echo "-- last_name column from recordset, keyed by value from first_name column --\n";
var_dump(array_column($records, 2, 1));

echo "*** Testing array_column() : object property fetching (string property names) ***\n";

echo "-- first_name column from recordset --\n";
var_dump(array_column($records, 'first_name'));

echo "-- id column from recordset --\n";
var_dump(array_column($records, 'id'));

echo "-- last_name column from recordset, keyed by value from id column --\n";
var_dump(array_column($records, 'last_name', 'id'));

echo "-- last_name column from recordset, keyed by value from first_name column --\n";
var_dump(array_column($records, 'last_name', 'first_name'));

echo "Done\n";
?>
