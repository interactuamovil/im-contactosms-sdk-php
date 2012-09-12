<?php

require_once 'SmsApi/contacts.php';
require_once 'SmsApi/groups.php';
require_once 'SmsApi/messages.php';
require_once 'SmsApi/accounts.php';

/**
 *
 */
class SmsApi {

    const VERSION = '0.1.0';

	public $contacts;
	public $groups;
	public $messages;
	public $account;

    /**
     * @param $api_key
     * @param $secret_key
     * @param $api_url
     */
    function SmsApi($api_key, $secret_key, $api_url){
		$this->contacts	= new ContactsApi($api_key, $secret_key, $api_url);
		$this->groups	= new GroupsApi($api_key, $secret_key, $api_url);
		$this->messages	= new MessagesApi($api_key, $secret_key, $api_url);
		$this->account	= new AccountsApi($api_key, $secret_key, $api_url);
	}

}
