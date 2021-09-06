<?php
class SomeConstants {const SOME_CONSTANT = SOME_NONSENSE;}

function handleError() {throw new ErrorException();}

set_error_handler('handleError');
set_exception_handler('handleError');

$r = new \ReflectionClass(SomeConstants::class);
$r->getConstants();
?>
