<?php
class LocalSoapClient extends SoapClient {
  function __doRequest($request, $location, $action, $version, $one_way = 0) {
    return <<<EOF
<?xml version="1.0" encoding="UTF-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns="urn:test.example.org" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:sf="urn:object.test.example.org"><soapenv:Body><queryResponse><result xsi:type="QueryResult"><done>true</done><queryLocator xsi:nil="true"/><records xsi:type="sf:genericObject"><sf:type>CampaignMember</sf:type><sf:Id>00vi0000011VMgeAAG</sf:Id><sf:Id>00vi0000011VMgeAAG</sf:Id><sf:CampaignId>701i0000001lreeAAA</sf:CampaignId><sf:Status>Sent</sf:Status><sf:ContactId xsi:nil="true"/><sf:LeadId>00Qi000001UrbYFEAZ</sf:LeadId><sf:Contact xsi:nil="true"/><sf:Lead xsi:type="sf:genericObject"><sf:type>Lead</sf:type><sf:Id xsi:nil="true"/><sf:Email>angela.lansbury@cbs.com</sf:Email></sf:Lead></records><size>1</size></result></queryResponse></soapenv:Body></soapenv:Envelope>
EOF;
  }
}
$client = new LocalSoapClient(dirname(__FILE__)."/bug73237.wsdl");
var_dump($client->query(""));
?>
