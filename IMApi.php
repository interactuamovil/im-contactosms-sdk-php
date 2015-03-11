<?php

include("libs/ContactsResource.php");

class IMApi {

    var $contactsResource;

    function __construct($apiKey, $apiSecret, $apiUrl){
        $this->contactsResource = new ContactsResource($apiKey,$apiSecret, $apiUrl);
    }

    function contacts(){
        return $this->contactsResource;
    }



}