<?php

class Test {
	public $prop;

	public function main(){
		assert('self::checkCacheKey(get_object_vars($this))');
		echo 'Success';
	}
	private static function checkCacheKey($obj_properties){
		return count($obj_properties) == 1;
	}
}

$obj = new Test();
$obj->main();

?>
