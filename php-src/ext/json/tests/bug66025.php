<?php

class Foo implements JsonSerializable {
    public function jsonSerialize() {
	    return json_encode([1], JSON_PRETTY_PRINT);
	}
}

echo json_encode([new Foo]), "\n";
?>
