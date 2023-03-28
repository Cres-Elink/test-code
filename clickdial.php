<?php
// Asterisk Manager Interface (AMI) credentials
$host = '192.168.2.178';
$username = 'click2callCres';
$password = 'click2callCres';

// Phone number to call
$phone_number = '8210';

// Connect to the Asterisk Manager Interface
$socket = fsockopen($host, 5038, $errno, $errstr, 10);
if (!$socket) {
    echo "Unable to connect to the Asterisk Manager Interface: $errstr ($errno)\n";
    exit(1);
}

// Authenticate with the Asterisk Manager Interface
fwrite($socket, "Action: Login\r\n");
fwrite($socket, "Username: $username\r\n");
fwrite($socket, "Secret: $password\r\n");
fwrite($socket, "Events: off\r\n\r\n");
$response = fread($socket, 4096);

// Send the Originate command to initiate the call
fwrite($socket, "Action: Originate\r\n");
fwrite($socket, "Channel: SIP/your_provider/$phone_number\r\n");
fwrite($socket, "Context: default\r\n");
fwrite($socket, "Exten: your_extension\r\n");
fwrite($socket, "Priority: 1\r\n");
fwrite($socket, "Callerid: your_callerid\r\n");
fwrite($socket, "Timeout: 30000\r\n\r\n");
$response = fread($socket, 4096);

// Close the socket connection  
fclose($socket);
?>