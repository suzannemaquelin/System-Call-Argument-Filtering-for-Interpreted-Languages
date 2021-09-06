<?php

function foo() {
	throw new Exception;
}

try {
	foo();
} catch (Exception $e) {
	echo "ok";
} finally {
	echo " ... ok";
}
