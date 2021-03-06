<?php
class C {
	private $priv1 = 'secret1';
	private $priv2 = 'secret2';
	public $pub1 = 'public1';
	public $pub2 = 'public2';
	public $pub3 = 'public3';
	public $pub4 = 'public4';
}

function showFirstTwoItems($it) {
  echo str_replace("\0", '\0', $it->key()) . " => " . $it->current() .
"\n";
  $it->next();
  echo str_replace("\0", '\0', $it->key()) . " => " . $it->current() .
"\n";
}

$ao = new ArrayObject(new C);
$ai = $ao->getIterator();

echo "--> Show the first two items:\n";
showFirstTwoItems($ai);

echo "\n--> Rewind and show the first two items:\n";
$ai->rewind();
showFirstTwoItems($ai);

echo "\n--> Invalidate current position and show the first two items:\n";
unset($ai[$ai->key()]);
$ai->current();
showFirstTwoItems($ai);

echo "\n--> Rewind, seek and show the first two items:\n";
$ai->rewind();
$ai->seek(0);
showFirstTwoItems($ai);
?>
