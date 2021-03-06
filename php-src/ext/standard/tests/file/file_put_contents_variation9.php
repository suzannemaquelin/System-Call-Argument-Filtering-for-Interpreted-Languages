<?php
/* Prototype  : int file_put_contents(string file, mixed data [, int flags [, resource context]])
 * Description: Write/Create a file with contents data and return the number of bytes written
 * Source code: ext/standard/file.c
 * Alias to functions:
 */

echo "*** Testing file_put_contents() : usage variation ***\n";

$filename = dirname(__FILE__).'/filePutContentsVar9.tmp';
$softlink = dirname(__FILE__).'/filePutContentsVar9.SoftLink';
$hardlink = dirname(__FILE__).'/filePutContentsVar9.HardLink';
$chainlink = dirname(__FILE__).'/filePutContentsVar9.ChainLink';


// link files even though it original file doesn't exist yet
symlink($filename, $softlink);
symlink($softlink, $chainlink);


// perform tests
run_test($chainlink);
run_test($softlink);

//can only create a hardlink if the file exists.
file_put_contents($filename,"");
link($filename, $hardlink);
run_test($hardlink);

unlink($chainlink);
unlink($softlink);
unlink($hardlink);
unlink($filename);


function run_test($file) {
    $data = "Here is some data";
    $extra = ", more data";
    var_dump(file_put_contents($file, $data));
    var_dump(file_put_contents($file, $extra, FILE_APPEND));
    readfile($file);
    echo "\n";
}


echo "\n*** Done ***\n";
?>
