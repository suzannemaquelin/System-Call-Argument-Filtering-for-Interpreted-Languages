<?php
try {
$p = new PharData(__DIR__."/bug71498.zip");
} catch(UnexpectedValueException $e) {
	echo $e->getMessage();
}
?>

DONE
