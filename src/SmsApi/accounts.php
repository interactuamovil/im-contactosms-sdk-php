<?php

require_once 'request.php';

/**
 *
 */
class AccountsApi extends ApiRequest {

    /**
     * @return mixed|object
     */
    public function status(){
		return $this->call('account/status', null, 'get', null);
	}

}