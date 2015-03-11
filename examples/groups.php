<?php
include("../src/SmsApi.php");

$api = new SmsApi("n90GovNeANyXaZWFkGC3TRhVAByRxrVg", "UE3BY99Kk2BUnfqJAq8YqqNnyy5pZ86Q", "http://localhost:8088/api", false /* Now I want objects... */);

print ("Getting groups...\n");
$groups = $api->groups()->getGroups();
if ($groups->status=="OK"){
    echo "My groups are:\n";
    foreach ($groups->data as $group) echo $group->name."\n";
} else {
    echo "Something went wrong, status {$groups->status} here is the dump!\n";
    var_dump($groups);
}

print ("Getting group pruebafeb...\n");
$group = $api->groups()->getByShortName("pruebafeb");
if ($group->status == "OK") echo "My group: {$group->data->name}\n";
else echo "No group :(\n";

print ("Creating group...\n");
$group = $api->groups()->createGroup("newgroup", "New group :)");
if ($group->status == "OK") echo "Group created!\n";
else echo "Failed to create group with status code $group->code\n";

print ("Updating group...\n");
$group = $api->groups()->updateGroup("newgroup", "New group...", "Hey this is my new group");
if ($group->status == "OK") echo "Group updated!\n";
else echo "Failed to update group with status code $group->code\n";


print ("Add contact to group...\n");
$response = $api->groups()->addContactToGroup("newgroup","50212345678");
if ($response->status == "OK") echo "Contact added!\n";
else echo "Failed to add contact with status code $response->code\n";


print ("Getting group contacts...\n");
$response = $api->groups()->getGroupContacts("newgroup",1,0,'SUSCRIBED',1);
if ($response->status == "OK"){
    foreach ($response->data as $contact) echo $contact->msisdn." - ".$contact->first_name."\n";
}
else echo "Failed to add contact with status code $response->code\n";


print ("Remove contact from group...\n");
$response = $api->groups()->deleteContactFromGroup("newgroup","50212345678");
if ($response->status == "OK") echo "Contact deleted...\n";
else echo "Failed to add contact with status code $response->code\n";


print ("Getting group contacts...\n");
$response = $api->groups()->getGroupContacts("newgroup",1,0,'SUSCRIBED',1);
if ($response->status == "OK"){
    foreach ($response->data as $contact) echo $contact->msisdn." - ".$contact->first_name."\n";
}
else echo "Failed to get contact with status code $response->code\n";

print ("Deleting group...\n");
$response = $api->groups()->deleteGroup("newgroup");
if ($response->status == "OK") echo "Group deleted\n";
else echo "Failed to delete group with status code $response->code\n";

print ("Getting available contacts...\n");
$response = $api->groups()->getAvailableContacts("pruebafeb");
if ($response->status == "OK"){
    echo "These contacts are not in my group...\n";
    foreach ($response->data as $contact) echo $contact->msisdn." - ".$contact->full_name."\n";
}
else echo "Failed get contacts with status code $response->code\n";

