<?php
$my = $_POST['regid'];
//enable it
//$deviceType = 'ios';
$deviceType = 'android';

$deviceToken = $my;
// Replace with real BROWSER API key from Google APIs
// $apiKey = "AIzaSyCg_XTK48PxL39bEh3RQ0HSOAaZW2pB39s";
include_once './config.php';
$apiKey = GOOGLE_API_KEY;
// Replace with real client registration IDs
$registrationIDs = array($deviceToken);

// Message to be sent
$message = "this is a test";

// Set POST variables
$url = 'https://android.googleapis.com/gcm/send';

$fields = array(
                'registration_ids'  => $registrationIDs,
                'data'              => array( "message" => $message ),
                );

$headers = array(
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                );

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt( $ch, CURLOPT_URL, $url );

curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

// Execute post
$result = curl_exec($ch);

// Close connection
curl_close($ch);

echo $result;
?>
