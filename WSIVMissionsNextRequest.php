<?php
class WSIVMissionsNextRequest {
    private $request;
    private $location;
    private $uri;
    private $action;
    private $version;
    private $client;

    private $station;
    private $direction;
    private $date;
    private $line;
    private $return;
    private $perturbations;
    private $missions;

    public function __construct($idLine, $stationName, $directionSens) {
        $this->location = "http://opendata-tr.ratp.fr/wsiv/services/Wsiv?wsdl=";
        $this->uri      = "http://opendata-tr.ratp.fr/wsiv/services";
        $this->action   = "urn:getMissionsNext";
        $this->version  = 0;
        $this->client   = new SoapClient(null, array('location' => $this->location,
                                            'uri'       => ""));

        $this->request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://wsiv.ratp.fr/xsd" xmlns:wsiv="http://wsiv.ratp.fr">
            <soapenv:Header/>
         <soapenv:Body>
             <wsiv:getMissionsNext>
                <wsiv:station>
                    <xsd:line>
                        <xsd:id>' . $idLine .'</xsd:id>
                    </xsd:line>
                    <xsd:name>' . $stationName . '</xsd:name>
                </wsiv:station>
                <wsiv:direction>
                    <xsd:sens>' . $directionSens . '</xsd:sens>
                </wsiv:direction>
             </wsiv:getMissionsNext>
         </soapenv:Body>
        </soapenv:Envelope>';

        $xmlstring = $this->client->__doRequest($this->request, $this->location, $this->action, $this->version);
        $clean_xml = str_ireplace(['SOAPENV:', 'NS1:', 'NS2:'], '', $xmlstring);
        $xml       = simplexml_load_string($clean_xml);

        $this->return        = $xml->Body->getMissionsNextResponse->return;
        $this->station       = $this->return->argumentStation->name;
        $this->direction     = $this->return->argumentDirection->name;
        $this->date          = $this->return->argumentDate;
        $this->line          = $this->return->argumentLine->reseau->name . ' ' . $this->return->argumentLine->code;
        $this->perturbations = $this->return->perturbations;
        $this->missions      = $this->return->missions;
    }


    public function getStation() {
        return $this->station;
    }

    public function getDirection() {
        return $this->direction;
    }

    public function getDate() {
        return strftime("%d %B %Y", strtotime($this->date));
    }

    public function getTime() {
        return strftime("%Hh%M", strtotime($this->date));
    }

    public function getLine() {
        return $this->line;
    }

    public function getPerturbations() {
        return $this->perturbations;
    }

    public function getMissions() {
        return $this->missions;
    }

}
