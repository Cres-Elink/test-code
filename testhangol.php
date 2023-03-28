<?php
// Set up connection parameters
$manager_host = "192.168.2.178";
$manager_user = "cresmanager";
$manager_pass = "grasya";
$manager_port = "5038";

// Connect to Asterisk Manager Interface (AMI)
$socket = fsockopen($manager_host, $manager_port, $errno, $errstr, 10);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: $manager_user\r\n");
fputs($socket, "Secret: $manager_pass\r\n\r\n");
$wrets=fgets($socket,128);

// Subscribe to call events
fputs($socket, "Action: Events\r\n");
fputs($socket, "Eventmask: on\r\n\r\n");

// Wait for incoming call events
while (true) {
  $wrets = fgets($socket, 8192);
  if (preg_match('/^Event: Newchannel/i', $wrets)) {
    // Extract call information from event
    preg_match('/CallerIDNum: (\d+)/', $wrets, $caller_id_match);
    preg_match('/CallerIDName: (.*)/', $wrets, $caller_name_match);
    preg_match('/Channel: (.*)/', $wrets, $channel_match);
    $caller_id = $caller_id_match[1];
    $caller_name = $caller_name_match[1];
    $channel = $channel_match[1];

    // Log call information to file
    $log_message = "New call from $caller_name <$caller_id> on $channel";
    file_put_contents("/var/log/asterisk/calls.log", $log_message . PHP_EOL, FILE_APPEND);
    echo $log_message;
  }
}
?>
