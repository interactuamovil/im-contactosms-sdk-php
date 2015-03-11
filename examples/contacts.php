<?php

include("../src/IMApi.php");

$api = new IMApi("n90GovNeANyXaZWFkGC3TRhVAByRxrVg", "UE3BY99Kk2BUnfqJAq8YqqNnyy5pZ86Q", "http://localhost:8088/api");

print ("Getting contacts...");
var_dump($api->contacts()->getContacts('796',10,1,'SUSCRIBED'));

print ("Deleting contact...");
var_dump($api->contacts()->deleteContact("50212345678"));
print ("Creating contact...");
var_dump($api->contacts()->createContact("12345678","502"));
print ("Updating contact...");
var_dump($api->contacts()->updateContact("50212345678","12345678","502","Alberto"));
print ("Getting contact groups...");
var_dump($api->contacts()->getContactGroups("50212345678"));
