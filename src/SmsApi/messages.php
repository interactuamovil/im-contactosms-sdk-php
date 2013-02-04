<?php

require_once 'request.php';

class MessagesApi extends ApiRequest{

	/**
	 * Obtiene el listado de mensajes enviados
	 * @param string $start_date Fecha desde la que se quieren obtener mensajes
	 * @param string $end_date Fecha hasta la que se quieren obtener mensajes
	 * @param string $start Utilizado para paginado
	 * @param string $limit Utilizado para paginado
	 * @param string $msisdn Código de país + número de teléfono para obtener solo los mensajes de un contacto
     * @return mixed
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
	 * Envía un mensaje a un grupo
	 * @param array $short_name Nombre corto del grupo al que se envía el mensaje
	 * @param string $message Mensaje que se desea enviar al grupo
     * @return mixed
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
	 * Envia un mensaje a un contacto
	 * @param string $msisdn Código de país + número de teléfono del contacto al que se envía el mensaje
	 * @param string $message Mensaje que se desea enviar al contacto
     * @return mixed
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
     * Obtiene los mensajes calendarizados
	 */
	public function get_schedule()
	{
		return $this->call("messages/scheduled", null, 'get', null);
	}

	/**
	 * Elimina un mensaje calendarizado
	 * @param int $message_id El ID del mensaje calendarizado a borraer
     * @return mixed
     */
	public function remove_schedule($message_id)
	{
		return $this->call("messages/scheduled", null, 'delete', array('message_id'=>$message_id));
	}

	/**
	 * Agrega un nuevo mensaje calendarizado
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
	 * Obtiene los mensajes de la bandeja de entrada
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

		return $this->call("messages/inbox", $p, 'get', null, true);
	}

}
