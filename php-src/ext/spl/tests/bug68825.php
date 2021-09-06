<?php
$dir = __DIR__ . '/bug68825';
mkdir($dir);
symlink(__FILE__, "$dir/foo");

$di = new \DirectoryIterator($dir);
foreach ($di as $entry) {
    if ('foo' === $entry->getFilename()) {
        var_dump($entry->getLinkTarget());
    }
}
?>
===DONE===
