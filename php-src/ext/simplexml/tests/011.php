<?php

$xml =<<<EOF
<?xml version="1.0" encoding="ISO-8859-1" ?>
<foo>
  <bar>bar</bar>
  <baz>baz1</baz>
  <baz>baz2</baz>
</foo>
EOF;

$sxe = simplexml_load_string($xml);

echo "===BAR===\n";
echo $sxe->bar;
echo "\n";

echo "===BAZ===\n";
echo $sxe->baz;
echo "\n";

echo "===BAZ0===\n";
echo $sxe->baz[0];
echo "\n";

echo "===BAZ1===\n";
print $sxe->baz[1];
echo "\n";
?>
===DONE===
