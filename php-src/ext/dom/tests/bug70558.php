<?php

class X extends \DOMDocument {

	public function __clone() {
		var_dump($this->registerNodeClass('DOMDocument', 'X'));
	}
}

$dom = clone (new X());
?>
