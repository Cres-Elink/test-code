<?php
// Connect to the Asterisk Manager Interface
$socket = fsockopen('192.168.2.178', 5038, $errno, $errstr, 1);
if (!$socket) {
    echo "$errstr ($errno)\n";
} else {
    // Login to AMI
    fputs($socket, "Action: Login\r\n");
    fputs($socket, "Username: cresmanager\r\n"); // on your localhost username if you register it on asterisk
    fputs($socket, "Secret: grasya\r\n\r\n");   //
    $loginresponse = fread($socket, 4096);
    // Set up event filters
    fputs($socket, "Action: Events\r\n");
    fputs($socket, "Eventmask: on\r\n\r\n");
    // Wait for incoming call event
    while (!feof($socket)) {
        $response = fgets($socket, 4096);
        if (strpos($response, "Event: Newchannel") !== false) {
            // Handle incoming call event
            // Extract relevant information from the response
            $channel = 'betty colon'; // channel name
            $callerid = 'some id'; // caller ID
            $context = 'default'; // context
            $extension = 'ext ari dri'; // extension
            // Do something with the information, such as send a notification
            // via email, SMS, or push notification
            // ...
            // Break out of the loop to wait for the next incoming call event
            break;
        }
    }
    // Log out of AMI
    fputs($socket, "Action: Logoff\r\n\r\n");
    fclose($socket);
}
?>