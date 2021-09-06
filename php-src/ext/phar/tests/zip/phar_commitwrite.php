<?php
$p = new Phar(dirname(__FILE__) . '/brandnewphar.phar.zip', 0, 'brandnewphar.phar');
$p['file1.txt'] = 'hi';
$p->stopBuffering();
var_dump($p->getStub());
$p->setStub("<?php
function __autoload(\$class)
{
    include 'phar://' . str_replace('_', '/', \$class);
}
Phar::mapPhar('brandnewphar.phar');
include 'phar://brandnewphar.phar/startup.php';
__HALT_COMPILER();
?>");
var_dump($p->getStub());
var_dump($p->isFileFormat(Phar::ZIP));
?>
===DONE===
