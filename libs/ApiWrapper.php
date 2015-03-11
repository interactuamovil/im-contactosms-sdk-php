<?php

function notEmptyValue($value){
    return $value;
}


class ApiWrapper {

    var $apiKey;
    var $apiSecret;
    var $apiUrl;

    function __construct($apiKey, $apiSecret, $apiUrl){
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        if ($apiUrl[strlen($apiUrl)-1] !== '/') {
            $apiUrl .= '/' ;
        }
        $this->apiUrl = $apiUrl;
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
        print($datetime."\n");
        $authentication = $this->apiKey.$datetime.$params.$body;
        print($authentication."|\n");
        print($this->apiSecret."|\n");
        $hash = hash_hmac("sha1",$authentication, $this->apiSecret,true);
        print($hash."\n");
        $hash = base64_encode($hash);
        $headers = array(
            "Content-type: application/json",
            "Date: $datetime",
            "Authorization: IM $this->apiKey:$hash",
        );
        print($hash."\n");
        
        $options = array(
            'http' => array(
                'header' => $headers,
                'method' => $method,
                'content' => $body,
                'ignore_errors' => true,
            ),
        );
        $context = stream_context_create($options);
        return file_get_contents($url,false, $context);
    }
}