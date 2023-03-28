<?php
// Define the SOAP client
$client = new SoapClient('http://your-suitecrm-url.com/service/v4/soap.php?wsdl');

// Set up the authentication parameters
$username = 'your-username';
$password = md5('your-password');
$session_id = $client->login($username, $password);

// Set up the call details
$call_details = array(
    'name' => 'Incoming Call from ' . $caller_id,
    'direction' => 'Inbound',
    'duration_hours' => 0,
    'duration_minutes' => $call_duration,
    'status' => 'Held',
    'parent_type' => 'Accounts',
    'parent_id' => $account_id,
    'date_start' => date('Y-m-d H:i:s', $call_start_time),
);

// Send the SOAP request to create the call record
$result = $client->__soapCall('set_entry', array(
    'session' => $session_id,
    'module_name' => 'Calls',
    'name_value_list' => $call_details,
));

// Process the response
if ($result->id) {
    // Call record created successfully
} else {
    // Error occurred
}



?>