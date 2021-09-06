<?php
class Stream {
	public function stream_open($path, $mode, $options, $opened_path) {
		return true;
	}

	public function stream_write($data) {
		return strlen($data) - 2;
	}
}

stream_wrapper_register('test', Stream::class);
file_put_contents('test://file.txt', 'foobarbaz');
?>
