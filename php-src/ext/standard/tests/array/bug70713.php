<?php

class obj
{
	function __tostring()
	{
		global $arr;

		$arr = 1;
		for ($i = 0; $i < 5; $i++) {
			$v[$i] = 'hi'.$i;
		}

		return 'hi';
	}
}

$arr = array('string' => new obj);
array_walk_recursive($arr, 'settype');

?>
