<?php

namespace Foo {
	class Bar {
		function Foo($bar) {
			var_dump($bar);
		}
	}
}

namespace {
	(new \Foo\Bar)->Foo("test");
}
