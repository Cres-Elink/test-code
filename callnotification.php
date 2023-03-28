<?php

// Set the following variables with your own values
$apiUrl = 'https://your-sugarcrm-domain.com/service/v4_1/rest.php';
$username = 'your-sugarcrm-username';
$password = 'your-sugarcrm-password';
$phoneNumberField = 'phone_mobile'; // The name of the phone number field in your contacts module
$pushNotificationToken = 'your-push-notification-token';

// Get the incoming phone number from your phone system
$incomingPhoneNumber = $_POST['incomingPhoneNumber'];

// Initialize the API client
$httpClient = curl_init();
curl_setopt($httpClient, CURLOPT_URL, $apiUrl);
curl_setopt($httpClient, CURLOPT_RETURNTRANSFER, true);
curl_setopt($httpClient, CURLOPT_POST, true);

// Create the API request to authenticate the user
$requestBody = array(
    'user_auth' => array(
        'user_name' => $username,
        'password' => md5($password),
        'version' => '1.0'
    ),
    'method' => 'login',
    'id' => '1'
);
curl_setopt($httpClient, CURLOPT_POSTFIELDS, http_build_query($requestBody));

// Send the API request to authenticate the user
$response = curl_exec($httpClient);
$responseData = json_decode($response, true);
$sessionId = $responseData['id'];

// Create the API request to get the contact with the incoming phone number
$requestBody = array(
    'session' => $sessionId,
    'module_name' => 'Contacts',
    'query' => "$phoneNumberField='$incomingPhoneNumber'",
    'order_by' => '',
    'offset' => 0,
    'select_fields' => array('id', 'first_name', 'last_name', 'email1'),
    'link_name_to_fields_array' => array(),
    'max_results' => 1,
    'deleted' => 0,
    'favorites' => false
);
curl_setopt($httpClient, CURLOPT_POSTFIELDS, http_build_query($requestBody));

// Send the API request to get the contact with the incoming phone number
$response = curl_exec($httpClient);
$responseData = json_decode($response, true);
$contact = $responseData['entry_list'][0]['name_value_list'];

// Create the API request to create a new call record
$requestBody = array(
    'session' => $sessionId,
    'module_name' => 'Calls',
    'name_value_list' => array(
        array('name' => 'name', 'value' => 'Incoming call from ' . $incomingPhoneNumber),
        array('name' => 'status', 'value' => 'Planned'),
        array('name' => 'direction', 'value' => 'Inbound'),
        array('name' => 'date_start', 'value' => date('Y-m-d H:i:s')),
        array('name' => 'parent_type', 'value' => 'Contacts'),
        array('name' => 'parent_id', 'value' => $contact['id']['value']),
        array('name' => 'description', 'value' => 'Incoming call from ' . $incomingPhoneNumber)
    )
);
curl_setopt($httpClient, CURLOPT_POSTFIELDS, http_build_query($requestBody));

// Send the API request to create a new call record
$response = curl_exec($httpClient);
$responseData = json_decode($response, true);
$callId = $responseData['id'];

// Close the API client
curl_close($httpClient);

// Send a push notification with the details of the new call record
$data = array(
    'title' => 'Incoming call',
    'message' => 'An incoming call was received from ' . $incoming
);
?>