<?php

assert(1);
assert('1');
assert('$a');

try {
	assert('aa=sd+as+safsafasfasafsaf');
} catch (Throwable $e) {
	echo $e->getMessage(), "\n";
}

assert('0');

assert_options(ASSERT_BAIL, 1);

try {
	assert('aa=sd+as+safsafasfasafsaf');
} catch (Throwable $e) {
	echo $e->getMessage(), "\n";
}

echo "done\n";

?>
