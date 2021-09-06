<?php
chdir(__DIR__);
try {
var_dump(new Phar('bug77143.phar',0,'project.phar'));
echo "OK\n";
} catch(UnexpectedValueException $e) {
	echo $e->getMessage();
}
?>
