<?php
class MyClass
{
    public static function doSomething()
    {
        echo "Did it!\n";
    }
}

$r = new ReflectionMethod('MyClass', 'doSomething');
$r->invoke('WTF?');
$r->invokeArgs('WTF?', array());
?>
===DONE===
