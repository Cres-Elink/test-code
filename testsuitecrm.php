<?php

$channel = "PJSIP/3315";
$strWaitTime = "30";
$strPriority = "1";
#specify the maximum amount of retries
$strMaxRetry = "2";
// Connect to the Asterisk Manager Interface
$socket = fsockopen('192.168.2.178', 5038, $errno, $errstr, 1);
if (!$socket) {
    echo "$errstr ($errno)\n";
} else {
    // Login to AMI
    fputs($socket, "Action: Login\r\n");
    fputs($socket, "Username: cresmanager\r\n");
    fputs($socket, "Secret: grasya\r\n\r\n");
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
            $channel = 'PJSIP/3315'; // channel name
            $callerid = 'Silouie'; // caller ID
            $context = 'default'; // context
            $extension = $number; // extension

            // Do something with the information, such as send a notification
            // via email, SMS, or push notification
            // ...

            // Break out of the loop to wait for the next incoming call event
            break;
        }
    }
    fputs($oSocket, "Action: login\r\n");
    fputs($oSocket, "Events: off\r\n");

    fputs($oSocket, "Action: originate\r\n");
    fputs($oSocket, "Channel: $channel\r\n");
    fputs($oSocket, "WaitTime: $strWaitTime\r\n");
    fputs($oSocket, "CallerId: $strCallerId\r\n");
    fputs($oSocket, "Exten: $number\r\n");
    fputs($oSocket, "Context: $context\r\n");
    fputs($oSocket, "Priority: $priority\r\n\r\n");
    // Log out of AMI
    fputs($socket, "Action: Logoff\r\n\r\n");
    fclose($socket);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test dial</title>
</head>
<body>
    <form action="" method="POST">
        Put number : 
    </form>
</body>
</html>