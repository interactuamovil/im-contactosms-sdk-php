<?php

require_once 'request.php';

class MessagesApi extends ApiRequest{

	/**
	 *
	 * Get messages log
	 * @param string $start_date
	 * @param string $end_date
	 * @param string $start
	 * @param string $limit
	 * @param string $msisdn
     * @return object|mixed
     */
	public function get_list($start_date=null, $end_date=null, $start=null, $limit=null, $msisdn=null)
	{
		$p = array();
		if(!empty($start_date) && !empty($end_date)){
			$p['start_date']	=	$start_date;
			$p['end_date']		=	$end_date;
		}
		if (!empty($start))
			$p['start']		=	$start;
		if (!empty($limit))
			$p['limit']		=	$limit;
		if (!empty($msisdn))
			$p['msisdn']	=	$msisdn;

		return $this->call("messages", $p, 'get', null, true);
	}

	/**
	 *
	 * Sends message to groups
	 * @param array $short_name
	 * @param string $message
     * @return object|mixed
     */
	public function send_to_groups($short_name, $message)
	{
		if (!is_array($short_name))
			return (object)array('error'=>'Parameter: short_name, must be an array');
		$p = array(
			'groups'	=>	$short_name,
			'message'	=>	$message
		);
		return $this->call("messages/send", null, 'post', $p);
	}

	/**
	 *
	 * Sends message to contact
	 * @param string $msisdn
	 * @param string $message
     * @return object|mixed
     */
	public function send_to_contact($msisdn, $message)
	{
		$p = array(
			'msisdn'	=>	$msisdn,
			'message'	=>	$message
		);
		return $this->call("messages/send_to_contact", null, 'post', $p);
	}

	/**
	 *
	 * Gets the schedule messages
	 */
	public function get_schedule()
	{
		return $this->call("messages/scheduled", null, 'get', null);
	}

	/**
	 *
	 * Deletes a schedule message
	 * @param int $message_id
     * @return object|mixed
     */
	public function remove_schedule($message_id)
	{
		return $this->call("messages/scheduled", null, 'delete', array('message_id'=>$message_id));
	}

	/**
	 *
	 * Adds a new schedule messsage
	 * @param string $start_date
     * @param string $end_date
     * @param string $name
     * @param string $message
     * @param string $time
     * @param string $frequency
     * @param array $groups
     * @return object|mixed
     */
	public function add_schedule($start_date, $end_date, $name, $message, $time, $frequency, $groups)
	{
		if( empty($start_date) || empty($end_date) || empty($name) || empty($message) || empty($time) || empty($frequency) || empty($groups) )
			return (object)array('error'=>'Parameters Missing');

		$p = array(
			'start_date'	=>	$start_date,
			'end_date'		=>	$end_date,
			'name'			=>	$name,
			'message'		=>	$message,
			'time'			=>	$time,
			'frequency'		=>	$frequency,
			'groups'		=>	$groups
		);
		return $this->call("messages/scheduled", null, 'post', $p);
	}

	/**
	 *
	 * Gets the inbox messages
	 * @param string $start_date
	 * @param string $end_date
	 * @param int $start
	 * @param int $limit
	 * @param string $msisdn
	 * @param string $status (read|unread)
     * @return object|mixed
     */
	public function inbox($start_date=null, $end_date=null, $start=null, $limit=null, $msisdn=null,  $status=null)
	{
		$p = array();
		if(!empty($start_date) && !empty($end_date)){
			$p['start_date']	=	$start_date;
			$p['end_date']		=	$end_date;
		}
		if (!empty($start))
			$p['start']		=	$start;
		if (!empty($limit))
			$p['limit']		=	$limit;
		if (!empty($msisdn))
			$p['msisdn']	=	$msisdn;
		if (!empty($status))
			$p['status']	=	$status;

		return $this->call("messages/messages_inbox", $p, 'get', null, true);
	}


}