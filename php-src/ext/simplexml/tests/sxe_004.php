<?php

$xml =<<<EOF
<?xml version='1.0'?>
<!DOCTYPE sxe SYSTEM "notfound.dtd">
<sxe id="elem1">
 Plain text.
 <elem1 attr1='first'>
  Bla bla 1.
  <!-- comment -->
  <elem2>
   Here we have some text data.
   <elem3>
    And here some more.
    <elem4>
     Wow once again.
    </elem4>
   </elem3>
  </elem2>
 </elem1>
 <elem11 attr2='second'>
  Bla bla 2.
  <elem111>
   Foo Bar
  </elem111>
 </elem11>
</sxe>
EOF;

class SXETest extends SimpleXMLIterator
{
	function rewind()
	{
		echo __METHOD__ . "\n";
		return parent::rewind();
	}
	function valid()
	{
		echo __METHOD__ . "\n";
		return parent::valid();
	}
	function current()
	{
		echo __METHOD__ . "\n";
		return parent::current();
	}
	function key()
	{
		echo __METHOD__ . "\n";
		return parent::key();
	}
	function next()
	{
		echo __METHOD__ . "\n";
		return parent::next();
	}
	function hasChildren()
	{
		echo __METHOD__ . "\n";
		return parent::hasChildren();
	}
	function getChildren()
	{
		echo __METHOD__ . "\n";
		return parent::getChildren();
	}
}

$sxe = new SXETest((binary)$xml);
$rit = new RecursiveIteratorIterator($sxe, RecursiveIteratorIterator::SELF_FIRST);

foreach($rit as $data) {
	var_dump(get_class($data));
	var_dump(trim($data));
}

?>
===DONE===
