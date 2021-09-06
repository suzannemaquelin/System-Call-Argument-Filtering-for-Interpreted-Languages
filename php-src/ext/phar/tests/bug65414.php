<?php
$phar = new \Phar(__DIR__ . '/bug65414.phar', 0, 'bug65414.phar');
$bads = [
    '.phar/injected-1.txt',
    '/.phar/injected-2.txt',
    '//.phar/injected-3.txt',
    '/.phar/',
];
foreach ($bads as $bad) {
    echo $bad . ':';
    try {
        $phar->addFromString($bad, 'this content is injected');
        echo 'Failed to throw expected exception';
    } catch (BadMethodCallException $ex) {
        echo $ex->getMessage() . PHP_EOL;
    }
}
echo 'done' . PHP_EOL;
?>
