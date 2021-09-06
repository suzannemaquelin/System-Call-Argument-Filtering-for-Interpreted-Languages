<?php
function testReflectionIsArray($a = null, $b = 0, array $c, $d=true, array $e, $f=1.5, $g="", array $h, $i="#F989898") {}

$reflection = new ReflectionFunction('testReflectionIsArray');

foreach ($reflection->getParameters() as $parameter) {
    var_dump($parameter->isArray());
}
?>
