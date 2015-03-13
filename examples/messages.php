<?php
date_default_timezone_set("America/Guatemala");
include("../src/SmsApi.php");

define('API_KEY', 'Your api key');
define('API_SECRET', 'Your api secret');
define('API_URL', 'Your api url');

$api = new SmsApi(API_KEY, API_SECRET, API_URL, false);


print ("Getting messages...");
// $api->messages()->getMessages($startDate,$endDate,$limit=null,$start=null,$msisdn=null,$groupShortName=null);
$response = $api->messages()->getMessages("2015-03-01", "2015-03-10",2);
if ($response->status == "OK"){
    foreach ($response->data as $message) echo $message->message."\n";
}
else echo "Failed to get messages with status code $response->code\n";



print ("Sending message to contact...");
// $api->messages()->sendToContact($msisdn,$message,$id=null);
$response = $api->messages()->sendToContact("50212345678", "Sent from PHP SDK");
if ($response->status == "OK") echo "I sent a message!\n";
else echo "Failed to send message with status code $response->code\n";



print ("Sending message to group...");
// $api->messages()->sendToGroups(array $groups, $message, $id=null);
$response = $api->messages()->sendToGroups(array("test"), "Test message to group");
if ($response->status == "OK") echo "I sent a message to the test group!";
else echo "Failed to send a message to group with status code $response->code\n";

