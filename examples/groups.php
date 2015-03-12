<?php
include("../src/SmsApi.php");

$api = new SmsApi(API_KEY, API_SECRET, API_URL, false /* Now I want objects... did you want array? change last parameter to true */);

// Response format:
// $response = [
//     'status' => 'OK',
//     'code' => '200',
//     'headers' => [/* the headers */]
//     'data' => [/*the data*/]
// ];


print ("Getting groups...\n");
// $groups = $api->groups()->getGroups($query=null, $limit=null,$start=null,$shortResults=null);
$groups = $api->groups()->getGroups();
if ($groups->ok){
    echo "My groups are:\n";
    foreach ($groups->data as $group) echo $group->name."\n";
} else {
    echo "Something went wrong, status {$groups->status} here is the dump!\n";
    var_dump($groups);
}

print ("Getting group pruebafeb...\n");

// $api->groups()->getByShortName($short_name);
$group = $api->groups()->getByShortName("pruebafeb");
if ($group->ok) echo "My group: {$group->data->name}\n";
else echo "No group :(\n";

print ("Creating group...\n");
// $group = $api->groups()->createGroup($shortName, $name=null, $description=null);
$group = $api->groups()->createGroup("newgroup", "New group :)");
if ($group->ok) echo "Group created!\n";
else echo "Failed to create group with status code $group->code\n";

print ("Updating group...\n");
// $api->groups()->updateGroup($shortName, $name=null, $description=null);
$group = $api->groups()->updateGroup("newgroup", "New group...", "Hey this is my new group");
if ($group->ok) echo "Group updated!\n";
else echo "Failed to update group with status code $group->code\n";


print ("Add contact to group...\n");
// $api->groups()->addContactToGroup($group, $msisdn);
$response = $api->groups()->addContactToGroup("newgroup","50212345678");
if ($response->ok) echo "Contact added!\n";
else echo "Failed to add contact with status code $response->code\n";


print ("Getting group contacts...\n");
// $api->groups()->getGroupContacts($shortName,$limit=null,$start=null,$status=null,$shortResults=null);
$response = $api->groups()->getGroupContacts("newgroup",1,0,'SUSCRIBED',1);
if ($response->ok){
    foreach ($response->data as $contact) echo $contact->msisdn." - ".$contact->first_name."\n";
}
else echo "Failed to add contact with status code $response->code\n";


print ("Remove contact from group...\n");
// $api->groups()->deleteContactFromGroup($group, $msisdn);
$response = $api->groups()->deleteContactFromGroup("newgroup","50212345678");
if ($response->ok) echo "Contact deleted...\n";
else echo "Failed to add contact with status code $response->code\n";


print ("Getting group contacts...\n");
// $api->groups()->getGroupContacts($shortName,$limit,$offset,$status,$shortResponse);
$response = $api->groups()->getGroupContacts("newgroup",1,0,'SUSCRIBED',1);
if ($response->ok){
    foreach ($response->data as $contact) echo $contact->msisdn." - ".$contact->first_name."\n";
}
else echo "Failed to get contact with status code $response->code\n";

print ("Deleting group...\n");
// $api->groups()->deleteGroup($shortname);
$response = $api->groups()->deleteGroup("newgroup");
if ($response->ok) echo "Group deleted\n";
else echo "Failed to delete group with status code $response->code\n";

print ("Getting available contacts...\n");
// $api->groups()->getAvailableContacts($shortname);
$response = $api->groups()->getAvailableContacts("pruebafeb");
if ($response->ok){
    echo "These contacts are not in my group...\n";
    foreach ($response->data as $contact) echo $contact->msisdn." - ".$contact->full_name."\n";
}
else echo "Failed get contacts with status code $response->code\n";

