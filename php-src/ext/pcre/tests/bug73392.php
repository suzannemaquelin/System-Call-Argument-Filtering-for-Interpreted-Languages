<?php
class Rep {
	public function __invoke() {
		return "d";
	}
}
class Foo {
	public static function rep($rep) {
		return "ok";
	}
}
function b() {
	return "b";
}
var_dump(preg_replace_callback_array(
	array(
		"/a/" => 'b',	"/b/" => function () { return "c"; }, "/c/" => new Rep, "reporting" => array("Foo", "rep"),  "a1" => array("Foo", "rep"),
	), 'a'));
?>
