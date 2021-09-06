<?php
$rm = new ReflectionMethod(DOMNode::class, "cloneNode");
printf("%d\n%d\n", $rm->getNumberOfParameters(), $rm->getNumberOfRequiredParameters());
foreach ($rm->getParameters() as $param) {
    printf("Parameter #%d %s OPTIONAL\n", $param->getPosition(), $param->isOptional() ? "IS" : "IS NOT");
}
?>
===DONE===
