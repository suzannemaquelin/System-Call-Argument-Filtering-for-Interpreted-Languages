<?php

class Test extends ArrayObject
{

	private $name = null;

	public function __construct(array $input)
	{
		parent::__construct($input, ArrayObject::ARRAY_AS_PROPS);
	}

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}
}

$test = new Test(['a' => 'a', 'b' => 'b']);
$test->setName('ok');

$ser = serialize($test);
$unSer = unserialize($ser);

var_dump($unSer->getName());
var_dump($unSer);

?>
