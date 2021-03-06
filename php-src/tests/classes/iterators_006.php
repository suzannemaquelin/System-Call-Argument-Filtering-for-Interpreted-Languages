<?php

class ai implements Iterator {

	private $array;

	function __construct() {
		$this->array = array('foo', 'bar', 'baz');
	}

	function rewind() {
		reset($this->array);
		$this->next();
	}

	function valid() {
		return $this->key !== NULL;
	}

	function key() {
		return $this->key;
	}

	function current() {
		return $this->current;
	}

	function next() {
		list($this->key, $this->current) = each($this->array);
//		list($key, $current) = each($this->array);
//		$this->key = $key;
//		$this->current = $current;
	}
}

class a implements IteratorAggregate {

	public function getIterator() {
		return new ai();
	}
}

$array = new a();

foreach ($array as $property => $value) {
	print "$property: $value\n";
}

#$array = $array->getIterator();
#$array->rewind();
#$array->valid();
#var_dump($array->key());
#var_dump($array->current());
echo "===2nd===\n";

$array = new ai();

foreach ($array as $property => $value) {
	print "$property: $value\n";
}

echo "===3rd===\n";

foreach ($array as $property => $value) {
	print "$property: $value\n";
}

?>
===DONE===
