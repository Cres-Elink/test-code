<?php
// Connect to the Asterisk Manager API
$socket = fsockopen("192.168.2.178", 5038, $errno, $errstr, 5);
fputs($socket, "Action: Login\r\n");
fputs($socket, "Username: cresmanager\r\n");
fputs($socket, "Secret: grasya\r\n\r\n");

// Wait for the response from Asterisk
while (!feof($socket)) {
  $buffer = fgets($socket);
  if (preg_match('/Message: Authentication accepted/', $buffer)) {
    break;
  }
}

// Send a command to Asterisk to get the Caller ID
fputs($socket, "Action: GetVar\r\n");
fputs($socket, "Channel: PJSIP/3315\r\n");
fputs($socket, "Variable: CALLERID(num)\r\n\r\n");

// Wait for the response from Asterisk
while (!feof($socket)) {
  $buffer = fgets($socket);
  if (preg_match('/Value: (\d+)/', $buffer, $matches)) {
    $caller_id = $matches[1];
    break;
  }
}

// Close the connection to the Asterisk Manager API
fputs($socket, "Action: Logoff\r\n\r\n");
fclose($socket);

// Compare the Caller ID to a list of allowed or blocked phone numbers
if (in_array($caller_id, $allowed_numbers)) {
  // Forward the call to the appropriate destination
} elseif (in_array($caller_id, $blocked_numbers)) {
  // Play a message indicating that the call cannot be accepted and hang up the call
}


?>