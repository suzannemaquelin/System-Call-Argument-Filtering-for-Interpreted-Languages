<?php

class myIterator implements Iterator {

function current (){}
function key ( ){}
function next ( ){}
function rewind ( ){}
function valid ( ){}


}

class TestRegexIterator extends RegexIterator{}

$rege = '/^a/';


$r = new TestRegexIterator(new myIterator, $rege);


try{
	$r->setPregFlags();
}catch (Exception $e) {
	echo $e->getMessage();
}

?>
