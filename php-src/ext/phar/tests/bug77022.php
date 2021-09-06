<?php
umask(022);
var_dump(decoct(umask()));

$sFile = tempnam(__DIR__, 'test77022');
var_dump(decoct(stat($sFile)['mode']));

foreach([Phar::TAR => 'tar', Phar::ZIP => 'zip'] as $mode => $ext) {
	clearstatcache();
	$phar = new PharData(__DIR__ . '/test77022.' . $ext, null, null, $mode);
	$phar->addFile($sFile, 'test-file-phar');
	$phar->addFromString("test-from-string", 'test-file-phar');
	$phar->extractTo(__DIR__);
	var_dump(decoct(stat(__DIR__ . '/test-file-phar')['mode']));
	var_dump(decoct(stat(__DIR__ . '/test-from-string')['mode']));
	unlink(__DIR__ . '/test-file-phar');
	unlink(__DIR__ . '/test-from-string');
	unlink(__DIR__ . '/test77022.' . $ext);
}
unlink($sFile);
?>
