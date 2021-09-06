<?php
$xml=<<<EOF
<?xml version="1.0"?>
<test/>
EOF;

$xsd=<<<EOF
<?xml version="1.0"?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:include schemaLocation="nonexistent.xsd"/>
  <xs:element name="test"/>
</xs:schema>
EOF;

libxml_set_external_entity_loader(function($p,$s,$c) {
    var_dump($p,$s,$c);
    die();
});

$dom=new DOMDocument($xml);
$dom->schemaValidateSource($xsd);
?>
