<?php
$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://wsiv.ratp.fr/xsd" xmlns:wsiv="http://wsiv.ratp.fr">
    <soapenv:Header/>
 <soapenv:Body>
     <wsiv:getMissionsNext>
        <wsiv:station>
            <xsd:line>
                <xsd:id>RB</xsd:id>
            </xsd:line>
            <xsd:name>Lozere</xsd:name>
        </wsiv:station>
        <wsiv:direction>
            <xsd:sens>A</xsd:sens>
        </wsiv:direction>
     </wsiv:getMissionsNext>
 </soapenv:Body>
</soapenv:Envelope>';
$location = "http://opendata-tr.ratp.fr/wsiv/services/Wsiv?wsdl=";
$uri      = "http://opendata-tr.ratp.fr/wsiv/services";
$action   = "urn:getMissionsNext";
$version  = 0;

$client = new SoapClient(null, array('location' => $location,
                                    'uri'       => ""));
$xmlstring = $client->__doRequest($request, $location, $action, $version);
$clean_xml = str_ireplace(['SOAPENV:', 'NS1:', 'NS2:'], '', $xmlstring);
$xml       = simplexml_load_string($clean_xml);

$return        = $xml->Body->getMissionsNextResponse->return;
$perturbations = array();
$missions      = array();

$station     = $return->argumentStation->name;
$direction   = $return->argumentDirection->name;
$line        = $return->argumentLine->reseau->name . ' ' . $return->argumentLine->code;

echo "Station $station ($line) en direction de $direction",PHP_EOL;

foreach($return->perturbations as $perturbation) {
    echo $perturbation->message->text,PHP_EOL;
}

foreach($return->missions as $mission) {
    $id = isset($mission->id) ? $mission->id . ' ' : "";
    echo $id, $mission->stations[1]->name, ': ', $mission->stationsMessages;
}
