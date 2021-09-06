<?php
try {
    // open an existing phar
    $p = new Phar(__DIR__."/bug69720.phar",0);
    // Phar extends SPL's DirectoryIterator class
	echo $p->getMetadata();
    foreach (new RecursiveIteratorIterator($p) as $file) {
        // $file is a PharFileInfo class, and inherits from SplFileInfo
	$temp="";
        $temp= $file->getFileName() . "\n";
        $temp.=file_get_contents($file->getPathName()) . "\n"; // display contents
	var_dump($file->getMetadata());
    }
}
 catch (Exception $e) {
    echo 'Could not open Phar: ', $e;
}
?>
