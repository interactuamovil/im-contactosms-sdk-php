<?php

function notEmptyValue($value){
    return $value;
}


class ApiWrapper {

    var $apiKey;
    var $apiSecret;
    var $apiUrl;
    var $assoc;

    function __construct($apiKey, $apiSecret, $apiUrl, $assoc){
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        if ($apiUrl[strlen($apiUrl)-1] !== '/') {
            $apiUrl .= '/' ;
        }
        $this->apiUrl = $apiUrl;
        $this->assoc = $assoc;
    }

    public function checkContactStatus($status){
        if ($status){
            if (!in_array($status,array(
                "SUSCRIBED","CONFIRMED","CANCELLED","INVITED",
            ))) throw new Exception("Status is not a valid status");
        }
    }

    public function checkInteger($value, $boolean=false){
        if (!$value) return;
        if (!is_numeric($value)) throw new Exception("Value $value is not numeric.");
        if ($boolean && $value!='1' && $value!='0') throw new Exception("Value $value is not 0 or 1.");
    }

    public function checkDate(&$value, $required=false){
        if (!$value && !$required) return;
        if (!is_numeric($value)) $value = strtotime($value);
        if (!$value) throw new Exception("Value $value is not a date.");
        $value = date("Y-m-d H:i:s",$value);
    }

    public function checkArray($value, $required=false){
        if (!is_array($value)) throw new Exception("$value is not an array");
    }


    public function getParamsString($params){
        if ($params) {
            if (!is_array($params) && !is_object($params)) throw new Exception('expected array or object in $params');
            ksort($params);
            $params = http_build_query(array_filter($params, "notEmptyValue"));
        }
        return $params;
    }

    public function getBodyString($body){
        if ($body) {
            if (!is_array($body) && !is_object($body)) throw new Exception('expected array or object in $body');
            $body = json_encode(array_filter($body,"notEmptyValue"));
        }
        return $body;
    }

    public function get($endpoint, $params=null){
        $url = $this->apiUrl.$endpoint;
        $params = $this->getParamsString($params);
        return $this->send($url,$params, 'GET', null);
    }

    public function post($endpoint, $params=null, $body=null){
        $url = $this->apiUrl.$endpoint;
        $params = $this->getParamsString($params);
        $body = $this->getBodyString($body);
        return $this->send($url,$params, 'POST', $body);
    }

    public function put($endpoint, $params=null, $body=null){
        $url = $this->apiUrl.$endpoint;
        $params = $this->getParamsString($params);
        $body = $this->getBodyString($body);
        return $this->send($url,$params, 'PUT', $body);
    }

    public function delete($endpoint, $params=null){
        $url = $this->apiUrl.$endpoint;
        $params = $this->getParamsString($params);
        return $this->send($url,$params, 'DELETE', null);
    }

    public function send($url, $params, $method, $body){
        if ($params) $url = $url."?".$params;
        $datetime = gmdate("D, d M Y H:i:s T");
        // print($datetime."\n");
        $authentication = $this->apiKey.$datetime.$params.$body;
        // print($authentication."|\n");
        // print($this->apiSecret."|\n");
        $hash = hash_hmac("sha1",$authentication, $this->apiSecret,true);
        // print($hash."\n");
        $hash = base64_encode($hash);
        $headers = array(
            "Content-type: application/json",
            "Date: $datetime",
            "Authorization: IM $this->apiKey:$hash",
            "X-IM-ORIGIN: IM_SDK_PHP",
        );
        // print($hash."\n");
        
        $options = array(
            'http' => array(
                'header' => $headers,
                'method' => $method,
                'content' => $body,
                'ignore_errors' => true,
            ),
        );
        $context = stream_context_create($options);
        $data = file_get_contents($url,false, $context);
        $json = json_decode($data,$this->assoc);
        $has_code = preg_match('/\ (\d+)\ /', $http_response_header[0], $response_code);
        if ($has_code) $response_code = $response_code[1];
        else $response_code = null;
        $has_status = preg_match('/\ ([^\ ]+)$/', $http_response_header[0], $status);
        if ($has_status) $status = $status[1];
        $data = array(
            'code' => $response_code,
            'status' => $status+0,
            'ok' => $status=="OK",
            'response_headers' => $http_response_header,
            'data' => $json,
        );
        return $this->assoc?$data:(object)$data;
    }
}