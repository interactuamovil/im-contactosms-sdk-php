<?php

require_once 'request.php';

class ContactsApi extends ApiRequest {

    public $CONFIRMED = 1;
    public $PENDING = 0;
    public $CANCELLED = 2;

    /**
     * @param bool|null $status
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $start
     * @param string|null $limit
     * @return mixed
     */
    public function get_list($status=null, $first_name=null, $last_name=null, $start=null, $limit=null){
		$p = array();
		if (!empty($start) && is_numeric($start)) {
            $p['start'] = $start;
        }
		if (!empty($limit) && is_numeric($limit)) {
            $p['limit'] = $limit;
        }
		if (!empty($first_name) && strlen($first_name)>0) {
            $p['first_name'] = $first_name;
        }
		if (!empty($last_name) && strlen($last_name)>0) {
            $p['last_name'] = $last_name;
        }
		if (!is_null($status) && is_numeric($status)) {
            $p['status'] = $status;
        }
		return $this->call('contacts', $p, 'get', null, true);
	}

	/**
	 *
	 * Get contact by msisdn
	 * @param string $msisdn
     * @return \object|mixed
     */
	public function get_by_msisdn($msisdn)
	{
		if( empty($msisdn) )
			return (object)array('error'=>'Parameters missing');
		return $this->call("contacts/$msisdn", array('msisdn'=>$msisdn), 'get', null);
	}

	/**
	 *
	 * Updates contact base on msisdn
	 * @param string $msisdn
	 * @param string $first_name
	 * @param string $last_name
	 * @param string $new_msisdn
     * @return object|mixed
     */
	public function update($msisdn, $first_name=null, $last_name=null, $new_msisdn=null)
	{
		if(empty($msisdn)) {
            return (object)array('error'=>'Parameters missing');
        }

		$p = array();
		if (!empty($msisdn)) {
            $p['msisdn'] = $msisdn;
        }
		if (!empty($first_name)) {
            $p['first_name'] = $first_name;
        }
		if (!empty($last_name)) {
            $p['last_name'] = $last_name;
        }
		if (!empty($new_msisdn)) {
            $p['msisdn'] = $new_msisdn;
        }

		return $this->call("contacts/$msisdn", array('msisdn'=>$msisdn), 'put', $p, false);
	}

	/**
	 *
	 * Adds a new contact
	 * @param string $msisdn
	 * @param string $first_name
	 * @param string $last_name
     * @return object|mixed
     */
	public function add($msisdn, $first_name=null, $last_name=null)
	{
		if(empty($msisdn)) {
            return (object)array('error'=>'Msisdn can\'t be empty');
        }

		$p = array();
		if (!empty($msisdn)) {
            $p['msisdn'] = $msisdn;
        }
		if (!empty($first_name)) {
            $p['first_name'] = $first_name;
        }
		if (!empty($last_name)) {
            $p['last_name'] = $last_name;
        }

		return $this->call("contacts/$msisdn", array('msisdn'=>$msisdn), 'post', $p);
	}

	/**
	 *
	 * Deletes a contact
	 * @param string $msisdn
     * @return object|mixed
     */
	public function delete($msisdn)
	{
		if(empty($msisdn)) {
            return (object)array('error'=>'Parameters missing');
        }
		return $this->call("contacts/$msisdn", array('msisdn'=>$msisdn), 'delete', null);
	}

	/**
	 *
	 * Gets contact's groups list
	 * @param string $msisdn
     * @return object|mixed
     */
	public function get_group_list($msisdn)
	{
		if(empty($msisdn)) {
            return (object)array('error'=>'Parameters missing');
        }
		return $this->call("contacts/$msisdn/groups", array('msisdn'=>$msisdn), 'get', null);
	}

}