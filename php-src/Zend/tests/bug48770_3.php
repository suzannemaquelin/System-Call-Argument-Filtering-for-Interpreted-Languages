<?php

class A {
	public function func($str) {
		var_dump(__METHOD__ .': '. $str);
	}
	private function func2($str) {
		var_dump(__METHOD__ .': '. $str);
	}
	protected function func3($str) {
		var_dump(__METHOD__ .': '. $str);
	}
	private function func22($str) {
		var_dump(__METHOD__ .': '. $str);
	}
}

class B extends A {
	public function func($str) {
  		call_user_func_array(array($this, 'self::func2'), array($str));
  		call_user_func_array(array($this, 'self::func3'), array($str));
  		call_user_func_array(array($this, 'self::inexistent'), array($str));
	}
	private function func2($str) {
		var_dump(__METHOD__ .': '. $str);
	}
	protected function func3($str) {
		var_dump(__METHOD__ .': '. $str);
	}
}

class C extends B {
	public function func($str) {
		parent::func($str);
	}
}

$c = new C;
$c->func('This should work!');

?>
