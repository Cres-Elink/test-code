<?php
// create a new SOAP client
$client = new SoapClient("http://<asterisk-server-ip>:8088/asterisk/wsdl");

// set the authentication credentials for the SOAP client
$client->__setSoapHeaders(new SoapHeader("http://<asterisk-server-ip>:8088/asterisk", "LoginCredentials", array("username" => "<username>", "password" => "<password>")));

// initiate a call to a phone number
$response = $client->Originate(array("Channel" => "SIP/<outgoing-extension>", "Context" => "<outgoing-context>", "Exten" => "<phone-number>", "Priority" => "1", "Callerid" => "<outgoing-caller-id>", "Timeout" => "30000"));



?>