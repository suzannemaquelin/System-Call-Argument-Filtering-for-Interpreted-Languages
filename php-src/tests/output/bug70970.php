<?php
function exception_error_handler($severity, $message, $file, $line)
{
	throw new Exception($message, 0);
}

set_error_handler('exception_error_handler');

function obHandler($buffer, $phase = null)
{
	try {
		ob_start();
	} catch (Exception $e) {
		return (string) $e;
	}

	return $buffer;
}

ob_start('obHandler');

print 'test';
?>
