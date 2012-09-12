<?php

require_once 'request.php';

class GroupsApi extends ApiRequest{

	/**
	 *
	 * Gets groups list
	 */
	public function get_list()
	{
		return $this->call('groups', null, 'get', null);
	}

	/**
	 *
	 * Gets groups data base on its short name
	 * @param string $short_name
     * @return object|mixed
     */
	public function get($short_name)
	{
		if( empty($short_name) )
			return (object)array('error'=>'Parameters missing');
		return $this->call("groups/$short_name", array('short_name'=>$short_name), 'get', null);
	}

	/**
	 *
	 * Updates groups info
	 * @param string $short_name
	 * @param string $name
	 * @param string $description
	 * @param string $new_short_name
     * @return object|mixed
     */
	public function update($short_name, $name, $description=null, $new_short_name=null)
	{
		if( empty($short_name) || empty($name)) {
            return (object)array('error'=>'Parameters missing');
        }

		$p = array(
			'name'			=>	$name,
			'description'	=>	$description
		);

		if(!empty($new_short_name) && strlen($new_short_name)> 0 )
			$p['short_name'] = $new_short_name;

		return $this->call("groups/$short_name", array('short_name'=>$short_name), 'put', $p);
	}

	/**
	 *
	 * Adds a new groups
	 * @param string $short_name
	 * @param string $name
	 * @param string $description
     * @return object|mixed
     */
	public function add($short_name, $name, $description=null)
	{
		if( empty($short_name) || empty($name)) {
            return (object)array('error'=>'Parameters missing');
        }

		$p = array(
			'short_name'	=> 	$short_name,
			'name'			=>	$name,
			'description'	=>	$description
		);

		return $this->call("groups/$short_name", array('short_name'=>$short_name), 'post', $p);
	}

	/**
	 *
	 * Desactivates a groups
	 * @param string $short_name
     * @return object|mixed
     */
	public function delete($short_name)
	{
		if( empty($short_name) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name", array('short_name'=>$short_name), 'delete', null);
	}

	/**
	 *
	 * Gets group contacts'
	 * @param string $short_name
     * @return object|mixed
     */
	public function get_contact_list($short_name)
	{
		if( empty($short_name) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name/contacts", array('short_name'=>$short_name), 'get', null);
	}

	/**
	 *
	 * Adds a contact to a groups
	 * @param string $short_name
	 * @param string $msisdn
     * @return object|mixed
     */
	public function add_contact($short_name, $msisdn)
	{
		if( empty($short_name) || empty($msisdn) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name/contacts/$msisdn", array('short_name'=>$short_name, 'msisdn'=>$msisdn), 'post', null);
	}

	/**
	 *
	 * Removes a contact from a group
	 * @param string $short_name
	 * @param string $msisdn
     * @return object|mixed
     */
	public function remove_contact($short_name, $msisdn)
	{
		if( empty($short_name) || empty($msisdn) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name/contacts/$msisdn", array('short_name'=>$short_name, 'msisdn'=>$msisdn), 'delete', null);
	}

}