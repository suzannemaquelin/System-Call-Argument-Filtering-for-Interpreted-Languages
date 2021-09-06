<?php
function countOpenFiles() {
    exec('lsof -p ' . getmypid(), $out);
    return count($out);
}
$filename = __DIR__ . '/bug70417.tar';
@unlink("$filename.gz");
$openFiles1 = countOpenFiles();
$arch = new PharData($filename);
$arch->addFromString('foo', 'bar');
$arch->compress(Phar::GZ);
unset($arch);
$openFiles2 = countOpenFiles();
var_dump($openFiles1 === $openFiles2);
?>
