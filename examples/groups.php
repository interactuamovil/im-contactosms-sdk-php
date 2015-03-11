<?php
include("../src/SmsApi.php");

$api = new SmsApi("n90GovNeANyXaZWFkGC3TRhVAByRxrVg", "UE3BY99Kk2BUnfqJAq8YqqNnyy5pZ86Q", "http://localhost:8088/api");

print ("Getting groups...");
var_dump($api->groups()->getGroups());

print ("Getting group pruebafeb...");
var_dump($api->groups()->getByShortName("pruebafeb"));

print ("Creating group...");
var_dump($api->groups()->createGroup("newgroup", "New group :)"));

print ("Updating group...");
var_dump($api->groups()->updateGroup("newgroup", "New group...", "Hey this is my new group"));

print ("Add contact to group...");
var_dump($api->groups()->addContactToGroup("newgroup","50212345678"));

print ("Getting group contacts...");
var_dump($api->groups()->getGroupContacts("newgroup",1,0,'SUSCRIBED',1));

print ("Remove contact from group...");
var_dump($api->groups()->deleteContactFromGroup("newgroup","50212345678"));

print ("Getting group contacts...");
var_dump($api->groups()->getGroupContacts("newgroup",1,0,'SUSCRIBED',1));

print ("Deleting group...");
var_dump($api->groups()->deleteGroup("newgroup"));

print ("Getting available contacts...");
var_dump($api->groups()->getAvailableContacts("pruebafeb"));
