<?php
class A extends \ArrayObject
{
	protected $foo;

	public function __construct()
	{
		$this->foo = 'bar';
	}

	public function serialize()
	{
		unset($this->foo);
		$result = parent::serialize();
		$this->foo = 'bar';
		return $result;
	}
}

$a = new A();
$a->append('item1');
$a->append('item2');
$a->append('item3');
$b = new A();
$b->unserialize($a->serialize());
var_dump($b);
?>
