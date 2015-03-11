<?php
include_once("ApiWrapper.php");

class MessagesResource extends ApiWrapper {

    function __construct($apiKey, $apiSecret, $apiUrl,$assoc){
        parent::__construct($apiKey,$apiSecret,$apiUrl,$assoc);
    }

    
    public function getMessages($startDate,
        $endDate,$limit=null,$start=null,$msisdn=null,$groupShortName=null){
        $this->checkDate($startDate,1);
        $this->checkDate($endDate,1);
        $this->checkInteger($start);
        return $this->get("messages", array(
            'start_date' => $startDate,
            'end_date' => $endDate,
            'limit' => $limit,
            'start' => $start,
            'msisdn' => $msisdn,
            'group_short_name' => $groupShortName,
        ));
    }

    public function sendToContact($msisdn,$message,$id=null){
        return $this->post("messages/send_to_contact",null,array(
            'msisdn' => $msisdn,
            'message' => $message,
            'id' => $id,
        ));
    }

    public function sendToGroups($groups,$message,$id=null){
        $this->checkArray($groups);
        return $this->post("messages/send", null, array(
            'groups' => $groups,
            'message' => $message,
            'id' => $id,
        ));
    }

}