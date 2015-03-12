<?php

include("../src/SmsApi.php");

$api = new SmsApi(API_KEY, API_SECRET, API_URL, true); // hey you'll have your responses in arrays, did you want StdObject? change last parameter to false

// Response format:
// $response = [
//     'status' => 'OK',
//     'code' => '200',
//     'headers' => [/* the headers */]
//     'data' => [/*the data*/]
// ];


/// Deleting a contact....
echo ("Deleting contact...");
$response = $api->contacts()->deleteContact("50212345678");
if ($response['status']=="OK") echo "Contact deleted\n";
else echo "Something went wrong here is the data";
var_dump($response);

/// Creating a contact......
echo ("Creating contact...");
$contact = $api->contacts()->createContact("12345678","502" /*, $firstName, $lastName, 
        $custom_field1,$custom_field2, $custom_field3, $custom_field4, $custom_field5*/);
if ($response['status']=="OK") echo "I successfully created a contact!\n";

/// Retrieving a contact...

echo ("Getting contacts...\n");
// $api->contacts()->getContacts($query=null, $limit=null,$start=null,$status=null,$shortResults=null);
$contacts = $api->contacts()->getContacts('12345678' /* Or a name, it works too */,10,0,'SUSCRIBED');

// check if my answer was OK
if ($contacts['status'] =="OK"){ /* alternative: $contacts['code']==200 */
    echo "All my contacts are: \n";
    foreach ($contacts['data'] as $contact){
        echo "Phone Number: {$contact['phone_number']}, Name: {$contact['full_name']}\n";
    }
} 

/// Updating........
echo ("Updating contact...");
// $api->conacts()->updateContact($msisdn, $phoneNumber=null, $countryCode=null, $firstName=null, $lastName = null,$custom_field1=null,$custom_field2=null, $custom_field3=null, $custom_field4=null, $custom_field5=null);
$response = $api->contacts()->updateContact("50212345678","12345678","502","Alberto");
if ($response['status']=="OK") echo "Updated my contact\n";

/// Getting groups
echo ("Getting contact groups...\n");
$response = $api->contacts()->getContactGroups("50212345678");
echo "My contact belongs to:\n";
foreach ($response['data'] as $group){
    echo $group['name']."\n";
}
