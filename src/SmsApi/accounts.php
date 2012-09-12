<?php

require_once 'request.php';

/**
 *
 */
class AccountsApi extends ApiRequest {

    /**
     * Obtiene información de la cuenta en su estado actual
     * @return mixed
     */
    public function status(){
		return $this->call('account/status', null, 'get', null);
	}

}