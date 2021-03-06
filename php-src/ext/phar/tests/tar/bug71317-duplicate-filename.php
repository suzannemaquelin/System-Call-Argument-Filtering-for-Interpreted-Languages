<?php
include dirname(__FILE__) . '/files/tarmaker.php.inc';

$testDirectory = __DIR__ . '/files/test_bug71317';
$testTarFilename  = __DIR__ . '/files/test_bug71317.tar';

$tar = new tarmaker($testTarFilename, 'none');
$tar->init();
$tar->addFile('file1.txt', 'file1');
$tar->addFile('file2.txt', 'file2');
$tar->addFile('file3.txt', 'file3');
$tar->addFile('file4.txt', 'file4');
$tar->addFile('file5.txt', 'file5');
$tar->addFile('file2.txt', 'file2a');
$tar->close();

$fname = str_replace('\\', '/', $testTarFilename);
try {
	mkdir($testDirectory);
	$tar = new PharData($fname);
	$tar->extractTo($testDirectory);

	$fileContent = file_get_contents($testDirectory . '/file2.txt');
	$expectedContent = 'file2a';
	if ($fileContent !== $expectedContent) {
		throw new Exception(sprintf('Contents of file2.txt ("%s") is invalid, expected "%s"', $fileContent, $expectedContent));
	}
} catch(Exception $e) {
	echo $e->getMessage() . "\n";
}
?>
===DONE===
