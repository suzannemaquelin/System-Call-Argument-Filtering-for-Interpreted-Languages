<?php
class c_iter implements Iterator {

	private $obj;
	private $num = 0;

	function __construct($obj) {
		echo __METHOD__ . "\n";
		$this->obj = $obj;
	}
	function rewind() {
		echo __METHOD__ . "\n";
		$this->num = 0;
	}
	function valid() {
		$more = $this->num < $this->obj->max;
		echo __METHOD__ . ' = ' .($more ? 'true' : 'false') . "\n";
		return $more;
	}
	function current() {
		echo __METHOD__ . "\n";
		return $this->num;
	}
	function next() {
		echo __METHOD__ . "\n";
		$this->num++;
	}
	function key() {
		echo __METHOD__ . "\n";
		switch($this->num) {
			case 0: return "1st";
			case 1: return "2nd";
			case 2: return "3rd";
			default: return "???";
		}
	}
	function __destruct() {
		echo __METHOD__ . "\n";
	}
}

class c implements IteratorAggregate {

	public $max = 3;

	function getIterator() {
		echo __METHOD__ . "\n";
		return new c_iter($this);
	}
	function __destruct() {
		echo __METHOD__ . "\n";
	}
}

$t = new c();

foreach($t as $k => $v) {
	foreach($t as $w) {
		echo "double:$v:$w\n";
		break;
	}
}

unset($t);

print "Done\n";
?>
