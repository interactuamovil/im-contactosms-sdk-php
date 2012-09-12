<?php

require_once 'request.php';

class ContactsApi extends ApiRequest {

    public $CONFIRMED = 1;
    public $PENDING = 0;
    public $CANCELLED = 2;

    /**
     * Obtiene la lista de contactos según los parametros indicados
     * @param bool|null $status Estado del contacto, puede ser uno de CONFIRMED (1), PENDING (0) o CANCELLED (2)
     * @param string|null $first_name El nombre del contacto
     * @param string|null $last_name El apellido del contacto
     * @param string|null $start Utilizado para paginación
     * @param string|null $limit Utilizado para paginación
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
	 * Obtiene un contacto en base a su MSISDN (código de país + número de teléfono)
	 * @param string $msisdn Código de país + número de teléfono del contacto
     * @return mixed
     */
	public function get_by_msisdn($msisdn)
	{
		if( empty($msisdn) )
			return (object)array('error'=>'Parameters missing');
		return $this->call("contacts/$msisdn", array('msisdn'=>$msisdn), 'get', null);
	}

	/**
	 * Actualiza la información de un contacto en base a su MSISDN (código de país + número de telefono)
	 * @param string $msisdn Código de país + número de teléfono del contacto a actualizar
	 * @param string $first_name Nombre del contacto
	 * @param string $last_name Apellido del contacto
	 * @param string $new_msisdn Requerido si se quiere cambiar el número de teléfono asociado al contacto
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
	 * Agregar un nuevo contacto
	 * @param string $msisdn Código de país + número de teléfono del contacto a agregar
	 * @param string $first_name Nombre del contacto
	 * @param string $last_name Apellido del contacto
     * @return mixed
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
	 * Borra el contacto indicado por el parámetro MSISDN (código de país + número de telefono)
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
	 * Obtiene los grupos a los que pertenece un contacto
	 * @param string $msisdn Código de país + número de teléfono del contacto
     * @return mixed
     */
	public function get_group_list($msisdn)
	{
		if(empty($msisdn)) {
            return (object)array('error'=>'Parameters missing');
        }
		return $this->call("contacts/$msisdn/groups", array('msisdn'=>$msisdn), 'get', null);
	}

}