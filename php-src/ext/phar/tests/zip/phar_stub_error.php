<?php

$fname = dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.phar.zip';

$phar = new Phar($fname);
$phar->setStub($stub = '<?php echo "first stub\n"; __HALT_COMPILER(); ?>' . "\r\n");
$phar->setAlias('hio');
$phar['a'] = 'a';
$phar->stopBuffering();

var_dump($phar->getStub());
var_dump($phar->getStub() == $stub);

$newstub = '<?php echo "second stub\n"; _x_HALT_COMPILER(); ?>';
try
{
	$phar->setStub($newstub);
}
catch(exception $e)
{
	echo 'Exception: ' . $e->getMessage() . "\n";
}
var_dump($phar->getStub());
var_dump($phar->getStub() == $stub);
$phar->stopBuffering();
var_dump($phar->getStub());
var_dump($phar->getStub() == $stub);

?>
===DONE===
