<?php

include("libs/ContactsResource.php");
include("libs/GroupsResource.php");

class IMApi {

    var $contactsResource;
    var $groupsResource;

    function __construct($apiKey, $apiSecret, $apiUrl){
        $this->contactsResource = new ContactsResource($apiKey,$apiSecret, $apiUrl);
        $this->groupsResource = new GroupsResource($apiKey,$apiSecret, $apiUrl);
    }

    function contacts(){
        return $this->contactsResource;
    }

    function groups(){
        return $this->groupsResource;
    }



}