<?php
include_once("ApiWrapper.php");

class ContactsResource extends ApiWrapper {

    function __construct($apiKey, $apiSecret, $apiUrl,$assoc){
        parent::__construct($apiKey,$apiSecret,$apiUrl,$assoc);
    }

    public function getContacts($query=null, $limit=null,$start=null,$status=null,$shortResults=null){
        $this->checkContactStatus($status);
        $this->checkInteger($start);
        $this->checkInteger($limit);
        $this->checkInteger($shortResults,true);
        return $this->get("contacts", array(
            'query' => $query,
            'limit' => $limit,
            'start' => $start,
            'status' => $status,
            'shortResults' => $shortResults,
        ));
    }

    public function getContactGroups($msisdn){
        return $this->get("contacts/$msisdn/groups",array("msisdn" => $msisdn));
    }

    public function getContact($msisdn){
        return $this->get("contacts/$msisdn");
    }

    public function createContact($phoneNumber, $countryCode, $firstName=null, $lastName = null, 
        $field1=null,$field2=null, $field3=null, $field4=null, $field5=null){
        $msisdn = $countryCode.$phoneNumber;
        $body = array(
            'msisdn' => $msisdn,
            'phone_number' => $phoneNumber,
            'country_code' => $countryCode,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'custom_field_1' => $field1,
            'custom_field_2' => $field2,
            'custom_field_3' => $field3,
            'custom_field_4' => $field4,
            'custom_field_5' => $field5,
        );
        return $this->post("contacts/$msisdn", array("msisdn" => $msisdn), $body);
    }

    public function updateContact($msisdn, $phoneNumber=null, $countryCode=null, $firstName=null, $lastName = null, 
        $field1=null,$field2=null, $field3=null, $field4=null, $field5=null){
        $body = array(
            'msisdn' => $msisdn,
            'phone_number' => $phoneNumber,
            'country_code' => $countryCode,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'custom_field_1' => $field1,
            'custom_field_2' => $field2,
            'custom_field_3' => $field3,
            'custom_field_4' => $field4,
            'custom_field_5' => $field5,
        );
        return $this->put("contacts/$msisdn", array("msisdn" => $msisdn), $body);
    }

    public function deleteContact($msisdn){
        return $this->delete("contacts/$msisdn", array("msisdn" => $msisdn));
    }

}