<?php
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Access-Control-Allow-Origin: *");

$socket = fsockopen('192.168.2.178', 5038, $errno, $errstr);
fputs($socket, "Action: Login\r\n");
fputs($socket, "Username: kresmanager\r\n");
fputs($socket, "Secret: grasya\r\n");
fputs($socket, "Events: all\r\n\r\n");
$event = "";
while (!feof($socket)) {
  $buffer = fgets($socket, 4096);
  if (strpos($buffer, "Event: Newchannel") !== false) {
    $event .= "data: " . json_encode(parse_event($buffer)) . "\n\n";
    echo $event;
    ob_flush();
    flush();
    $event = "";
  }
}
function parse_event($buffer) {
  $data = array();
  foreach (explode("\r\n", $buffer) as $line) {
    list($key, $value) = explode(": ", $line);
    $data[$key] = $value;
  }
  return $data;
}
?>