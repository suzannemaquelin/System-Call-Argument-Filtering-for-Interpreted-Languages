<?php

class Foo {
	private $bar = 'baz';
}

echo json_encode(array(array(), (object) array(), new Foo), JSON_PRETTY_PRINT);

?>
