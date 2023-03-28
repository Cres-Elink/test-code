<?php
/*this is sample code for suite crm and yet to be tested later on if 
the pbx is up and runnign
*/
//
// Set the phone number to dial
$phone_number = '1234567890'; //using entrypoints you may fetch the number by getting $_get ['number']

// Set the extension to dial from
$extension = '105'; //sip ext nimo //set to 101 ky test paman ni

// Set the Asterisk server IP address
$server_ip = '192.168.2.178';

// Set the Asterisk server port (default is 5038)
$server_port = '5160';

// Set the Asterisk manager username and password
$manager_user = 'manager';
$manager_pass = '290bf4041c287f7f36a2f131182a6658';

// Connect to the Asterisk server
$socket = fsockopen($server_ip, $server_port, $errno, $errstr, 10);

if (!$socket) {
    echo "$errstr ($errno)<br />\n";
} else {
    // Send the login command to the Asterisk server
    fputs($socket, "Action: Login\r\n");
    fputs($socket, "Username: $manager_user\r\n");
    fputs($socket, "Secret: $manager_pass\r\n\r\n");

    // Wait for the server to respond
    while ($line = fgets($socket)) {
        if (trim($line) == 'ActionID: 1') {
            break;
        }
    }

    // Send the originate command to the Asterisk server
    fputs($socket, "Action: Originate\r\n");
    fputs($socket, "Channel: SIP/$extension\r\n");
    fputs($socket, "CallerID: SuiteCRM <$extension>\r\n");
    fputs($socket, "Exten: $phone_number\r\n");
    fputs($socket, "Context: default\r\n");
    fputs($socket, "Priority: 1\r\n\r\n");

    // Wait for the server to respond
    while ($line = fgets($socket)) {
        echo $line;
    }

    // Send the logoff command to the Asterisk server
    fputs($socket, "Action: Logoff\r\n\r\n");

    // Close the socket connection
    fclose($socket);
}



?>