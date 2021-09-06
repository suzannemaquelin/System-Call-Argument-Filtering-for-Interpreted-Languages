<?php
class SomeClass implements JsonSerializable {
	public function jsonSerialize() {
		return [get_object_vars($this)];
	}
}
$class = new SomeClass;
$arr = [$class];
var_dump(json_encode($arr));

class SomeClass2 implements JsonSerializable {
	public function jsonSerialize() {
		return [(array)$this];
	}
}
$class = new SomeClass2;
$arr = [$class];
var_dump(json_encode($arr));
?>
