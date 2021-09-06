<?php
	// empty protocol name
	var_dump(getprotobyname());

	// invalid protocol name
	var_dump(getprotobyname('abc'));
?>
