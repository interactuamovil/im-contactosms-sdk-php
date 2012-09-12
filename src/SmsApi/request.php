<?php

/**
 *
 */
class ApiRequest {

    private $api_key;
    private $secret_key;
    private $api_url;

    /**
     * @param $api_key
     * @param $secret_key
     * @param $api_url
     */
    function __construct($api_key, $secret_key, $api_url){
		$this->api_key = $api_key;
		$this->secret_key = $secret_key;
        if ($api_url[strlen($api_url)-1] !== '/') {
            $api_url .= '/' ;
        }
        $this->api_url = $api_url;
	}

    /**
     * @param $url
     * @param $get_params
     * @param $request
     * @param null $params
     * @param bool $add_to_query_string
     * @return object|mixed
     */
    protected function call($url, $get_params, $request, $params=null, $add_to_query_string=false)
	{
		if(!empty($params)) {
            $data = json_encode($params);
        }
	    else {
            $data = '';
        }

	    $filters = $this->to_query_string($get_params);
	    $date = gmdate("D, d M Y H:i:s T");

	    if ($request == 'get') {
	    	$canonical_string = $this->api_key.$date.$filters;
	    } else {
	    	$canonical_string = $this->api_key.$date.$filters.$data;
	    }

	    $b64_mac = base64_encode(hash_hmac('sha1', $canonical_string, $this->secret_key, true));

	    $hash = "IM ".$this->api_key.":".$b64_mac;

	    $headers = array(
	    	'Authorization: '.$hash,
	    	'Date: '.$date
	    );

		if ($add_to_query_string && strlen($filters)>0) {
            $url = $url."?$filters";
        }

	    return $this->send($url, $headers, $request, $data);

	}

    /**
     * @param $url
     * @param $headers
     * @param $request
     * @param bool $postargs
     * @return object|mixed
     */
    protected function send($url, $headers, $request, $postargs=false) {

		$url = $this->api_url.$url;

	    $ch = curl_init();
	    if($postargs !== false) {
	        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postargs);
	        $headers[] = 'Content-type: application/x-www-form-urlencoded; charset=UTF-8';
	    }

	    $request = strtoupper($request);

	    switch ($request) {
	    	case 'GET':
	    		$request = 'HTTPGET';
	    		break;
	    	case 'POST':
	    		break;
	    	case 'PUT':
	    		break;
	    	case 'DELETE':
	    		break;
	    	default:
	    		$request = false;
	    	break;
	    }

	    if ($request == false) {
            return (object)array('error'=>'Bad Request Method');
        }

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //array("Accept-Language: es-es,en"));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    	curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, '');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);

	    $response = curl_exec($ch);

	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    curl_close($ch);

	 	if ($httpCode == 200){
	 		if ($this->is_json($response)) {
                 return json_decode($response);
             }
	 		else {
                 return $response;
             }
	 	}elseif ($httpCode == 400){
	 		if ($this->is_json($response)) {
                 return json_decode($response);
            }
	 		else {

                 return $response;
            }
	 	}else{
	 		return $response;
	 	}
	}

    /**
     * @param $string
     * @return bool
     */
    private function is_json($string) {
	  return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
	}

    /**
     * @param $params
     * @return string
     */
    private function to_query_string($params){
		$first_item = true;
		$parameters = '';

    	if (!empty($params) && is_array($params) && count($params)>0){
    		ksort($params);
	    	foreach ($params as $param => $value){
	    		if ($param != 'format') {
		    		$parameters .= ($first_item) ? '' : '&';
		    		$parameters .= "$param=$value";
		    		$first_item = false;
	    		}
	    	}
    	}
    	return $parameters;
	}

}