<?php
header('Access-Control-Allow-Origin: *');  // this is the protocol  on suite crm you may direct copy and paste on asterisk module folder where you deploy since this is a backup
/*this is sample code for suite crm and yet to be tested later on if 
the pbx is up and runnign
*/
//
// Set the phone number to dial
$phone_number = $_GET['phone'];//change it according on what you put it on a href ="sample.com?<parameter>="
$name = $_GET['name'];//change it according on what you put it on a href ="sample.com?<parameter>=<attribute>&<parameter>=<attribute>"
// Set the extension to dial from
$extension = '8210'; //please set your ext according on your assign ext number
// Set the Asterisk server IP address
$server_ip = "192.168.2.178";

// Set the Asterisk server port (default is 5038)
$server_port = "5038";

// Set the Asterisk manager username and password
$manager_user = 'cresmanager';
$manager_pass = 'grasya';//set your cureent pasword

// Connect to the Asterisk server
$socket = fsockopen($server_ip, $server_port, $errno, $errstr, 10);
if (!$socket) {
    echo "$errstr  aguy ($errno)<br />\n";
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
    fputs($socket, "Channel: PJSIP/$phone_number\r\n");
    fputs($socket, "CallerID: $name <$extension>\r\n");
    fputs($socket, "Exten: $extension\r\n");
    fputs($socket, "Context: from-internal\r\n");
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