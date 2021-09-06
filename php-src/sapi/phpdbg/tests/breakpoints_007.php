<?php

class bar {
	function foo($bar) {
		var_dump($bar);
	}
}

(new bar)->foo("test");
