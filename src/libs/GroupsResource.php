<?php
include_once("ApiWrapper.php");

class GroupsResource extends ApiWrapper {

    function __construct($apiKey, $apiSecret, $apiUrl){
        parent::__construct($apiKey,$apiSecret,$apiUrl);
    }

    
    public function getGroups($query=null, $limit=null,$start=null,$shortResults=null){
        $this->checkInteger($start);
        $this->checkInteger($shortResults,true);
        return $this->get("groups", array(
            'query' => $query,
            'limit' => $limit,
            'start' => $start,
            'shortResults' => $shortResults,
        ));
    }

    public function getByShortName($shortName){
        return $this->get("groups/$shortName", array("short_name" => $shortName));
    }

    public function createGroup($shortName, $name=null, $description=null){
        
        $body = array(
            'short_name' => $shortName,
            'name' => $name?$name:$shortName,
            'description' => $description,
        );
        return $this->post("groups/$shortName", array("short_name" => $shortName), $body);
    }

    public function updateGroup($shortName, $name=null, $description=null){
        $body = array(
            'short_name' => $shortName,
            'name' => $name?$name:$shortName,
            'description' => $description,
        );
        return $this->put("groups/$shortName", array("short_name" => $shortName), $body);
    }

    public function deleteGroup($shortName){
        return $this->delete("groups/$shortName", array("short_name" => $shortName));
    }

    public function getGroupContacts($shortName,$limit=null,$start=null,$status=null,$shortResults=null){
        $this->checkContactStatus($status);
        $this->checkInteger($limit);
        $this->checkInteger($start);
        $this->checkInteger($shortResults,true);
        return $this->get("groups/$shortName/contacts", array(
            'short_name' => $shortName,
            'limit' => $limit,
            'start' => $start,
            'status' => $status,
            'shortResults' => $shortResults,
        ));
    }

    public function getAvailableContacts($shortName){
        return $this->get("groups/$shortName/available_contacts", array(
            'short_name' => $shortName,
        ));
    }

    public function addContactToGroup($shortName, $msisdn){
        return $this->post("groups/$shortName/contacts/$msisdn", array(
            "msisdn" => $msisdn,
            "short_name" => $shortName,
        ));
    }

    public function deleteContactFromGroup($shortName, $msisdn){
        return $this->delete("groups/$shortName/contacts/$msisdn", array(
            "msisdn" => $msisdn,
            "short_name" => $shortName,
        ));
    }



}