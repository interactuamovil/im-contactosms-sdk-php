<?php
date_default_timezone_set("America/Guatemala");
include("../src/SmsApi.php");

$api = new SmsApi("n90GovNeANyXaZWFkGC3TRhVAByRxrVg", "UE3BY99Kk2BUnfqJAq8YqqNnyy5pZ86Q", "http://localhost:8088/api");

print ("Getting messages...");
var_dump($api->messages()->getMessages("2015-03-01", "2015-03-10",2));

print ("Sending message to contact...");
var_dump($api->messages()->sendToContact("50212345678", "Sent from PHP SDK"));

print ("Sending message to group...");
var_dump($api->messages()->sendToGroups(array("test"), "Test message to group"));
