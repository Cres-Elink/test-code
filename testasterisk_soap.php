<?php
// Get the inbound call data from Asterisk
$callerNumber = $_REQUEST['callerid'];
$uniqueId = $_REQUEST['uniqueid'];
$callDate = date('Y-m-d H:i:s', strtotime($_REQUEST['datetime']));
$callStatus = $_REQUEST['status'];
$callDuration = $_REQUEST['duration'];

// Set up the SOAP client
$client = new SoapClient('http://your-suitecrm-url/service/v4/soap.php?wsdl');

// Log in to SuiteCRM
$username = 'your-username';
$password = 'your-password';
$user_auth = $client->__call('login', array(
    array(
        'user_name' => $username,
        'password' => md5($password),
    ),
    'SugarCRM',
));

// Create a new call record in SuiteCRM
$callRecord = array(
    'name' => 'Inbound Call from ' . $callerNumber,
    'direction' => 'Inbound',
    'parent_type' => 'Leads',
    'parent_id' => '123456', // Replace with the ID of the lead you want to associate the call with
    'date_start' => $callDate,
    'duration_hours' => 0,
    'duration_minutes' => $callDuration,
    'status' => $callStatus,
    'description' => 'Inbound call from ' . $callerNumber,
    'assigned_user_id' => $user_auth->id,
);

$callId = $client->__call('set_entry', array(
    $user_auth->id,
    'Calls',
    $callRecord,
));

// Log out of SuiteCRM
$client->__call('logout', array($user_auth->id));

// Output the call ID for debugging purposes
echo 'Call ID: ' . $callId;

?>