<?php

namespace X;

$iterator =
    new \RegexIterator(
        new \ArrayIterator(['A.phpt', 'B.phpt', 'C.phpt']),
        '/\.phpt$/'
    )
;

foreach ($iterator as $foo) {
    var_dump($foo);
    preg_replace('/\.phpt$/', '', '');
}

echo "Done", PHP_EOL;

?>
