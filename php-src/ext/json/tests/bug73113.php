<?php

class JsonSerializableObject implements \JsonSerializable
{
    public function jsonSerialize()
    {
        throw new \Exception('This error is expected');
    }
}

$obj = new JsonSerializableObject();
try {
	echo json_encode($obj);
} catch (\Exception $e) {
	echo $e->getMessage();
}
