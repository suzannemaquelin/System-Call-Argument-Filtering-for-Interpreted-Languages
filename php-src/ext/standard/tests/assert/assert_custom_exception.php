<?php
class CustomException extends Exception {}
assert(false, new CustomException('Exception message'));
?>
