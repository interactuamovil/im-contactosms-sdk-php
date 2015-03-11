<?php
date_default_timezone_set("America/Guatemala");
include("../src/SmsApi.php");

$api = new SmsApi("n90GovNeANyXaZWFkGC3TRhVAByRxrVg", "UE3BY99Kk2BUnfqJAq8YqqNnyy5pZ86Q", "http://localhost:8088/api", false);

print ("Getting messages...");
$response = $api->messages()->getMessages("2015-03-01", "2015-03-10",2);
if ($response->status == "OK"){
    foreach ($response->data as $message) echo $message->message."\n";
}
else echo "Failed to get messages with status code $response->code\n";


print ("Sending message to contact...");
$resposne = $api->messages()->sendToContact("50212345678", "Sent from PHP SDK");
if ($response->status == "OK") echo "I sent a message!\n";
else echo "Failed to send message with status code $response->code\n";


print ("Sending message to group...");
$response = $api->messages()->sendToGroups(array("test"), "Test message to group");
if ($response->status == "OK") echo "I sent a message to the test group!";
else echo "Failed to send a message to group with status code $response->code\n";

