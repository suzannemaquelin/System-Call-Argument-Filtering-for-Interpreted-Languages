<?php

class StreamExploiter {
	public function stream_close (  ) {
		$doc = new DOMDocument;
		$doc->appendChild($doc->createTextNode('hello'));
		var_dump($doc->save(dirname(getcwd()) . '/bad'));
	}

	public function stream_open (  $path ,  $mode ,  $options ,  &$opened_path ) {
		return true;
	}
}

var_dump(mkdir('test_bug_61367-write'));
var_dump(mkdir('test_bug_61367-write/base'));
var_dump(file_put_contents('test_bug_61367-write/bad', 'blah'));
var_dump(chdir('test_bug_61367-write/base'));

stream_wrapper_register( 'exploit', 'StreamExploiter' );
$s = fopen( 'exploit://', 'r' );

?>
