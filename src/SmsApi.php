<?php

include_once("libs/ContactsResource.php");
include_once("libs/GroupsResource.php");
include_once("libs/MessagesResource.php");

class SmsApi {

    var $contactsResource;
    var $groupsResource;

    function __construct($apiKey, $apiSecret, $apiUrl,$assoc=false){
        $this->contactsResource = new ContactsResource($apiKey,$apiSecret, $apiUrl,$assoc);
        $this->groupsResource = new GroupsResource($apiKey,$apiSecret, $apiUrl,$assoc);
        $this->messagesResource = new MessagesResource($apiKey,$apiSecret, $apiUrl,$assoc);
    }

    function contacts(){
        return $this->contactsResource;
    }

    function groups(){
        return $this->groupsResource;
    }

    function messages(){
        return $this->messagesResource;
    }



}