<?php

header_register_callback(function () {
	echo 'header';
	register_shutdown_function(function () {
		echo 'shutdown';
	});
});
?>
