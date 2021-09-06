<?php
chdir(__DIR__);
try {
$p = Phar::LoadPhar('bug73768.phar', 'alias.phar');
echo "OK\n";
} catch(PharException $e) {
	echo $e->getMessage();
}
?>
