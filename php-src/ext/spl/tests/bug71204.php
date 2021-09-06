<?php

spl_autoload_register(function ($name) {
	spl_autoload_unregister("spl_autoload_call");
});

spl_autoload_register(function ($name) {
});

new A();
?>
