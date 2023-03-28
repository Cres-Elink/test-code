<?php
//save as Asterisk config.php sa crm

// Asterisk Manager Interface (AMI) settings
$host = "localhost"; // Asterisk server IP address or hostname
$port = "5038"; // AMI port (default is 5038)
$username = "admin"; // AMI username
$password = "password"; // AMI password

// Connect to the AMI
$socket = fsockopen($host,$port, $errno, $errstr, 10);
if (!$socket) {
    echo "$errstr ($errno)<br />\n";
} else {
    // Login to the AMI
    fputs($socket, "Action: Login\r\n");
    fputs($socket, "Username: $username\r\n");
    fputs($socket, "Secret: $password\r\n\r\n");
    
    // Wait for the login response
    while (!feof($socket)) {
        $line = fgets($socket, 4096);
        if (strpos($line, "Message: Authentication accepted") !== false) {
            break;
        }
    }
    
    // Send a command to retrieve the Asterisk server status
    fputs($socket, "Action: Status\r\n\r\n");
    
    // Wait for the response
    while (!feof($socket)) {
        $line = fgets($socket, 4096);
        echo $line;
    }
    
    // Logout from the AMI
    fputs($socket, "Action: Logoff\r\n\r\n");
    
    // Close the socket
    fclose($socket);
}
?>
