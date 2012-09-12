<?php

require_once 'request.php';

class GroupsApi extends ApiRequest{

	/**
	 * Listado de grupos
	 */
	public function get_list()
	{
		return $this->call('groups', null, 'get', null);
	}

	/**
	 * Obtiene un grupo en base a su nombre corto
	 * @param string $short_name Nombre corto del grupo
     * @return mixed
     */
	public function get($short_name)
	{
		if( empty($short_name) )
			return (object)array('error'=>'Parameters missing');
		return $this->call("groups/$short_name", array('short_name'=>$short_name), 'get', null);
	}

	/**
	 * Actualiza la información del grupo indicado por el nombre corto del grupo
	 * @param string $short_name Nombre corto del grupo
	 * @param string $name Nombre del grupo
	 * @param string $description Descripción del grupo
	 * @param string $new_short_name Nuevo nombre corto del grupo si se desea cambiar
     * @return mixed
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
	 * Agrega un nuevo grupo
     * @param string $short_name Nombre corto del grupo
     * @param string $name Nombre del grupo
     * @param string $description Descripción del grupo
     * @return mixed
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
	 * Borra el grupo indicado por el nombre corto del mismo
	 * @param string $short_name Nombre corto del grupo a borrar
     * @return mixed
     */
	public function delete($short_name)
	{
		if( empty($short_name) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name", array('short_name'=>$short_name), 'delete', null);
	}

	/**
	 * Obtiene los contactos de un grupo
	 * @param string $short_name Nombre corto del grupo
     * @return mixed
     */
	public function get_contact_list($short_name)
	{
		if( empty($short_name) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name/contacts", array('short_name'=>$short_name), 'get', null);
	}

	/**
	 * Agregar un contacto un grupo
	 * @param string $short_name Nombre corto del grupo al que se agregará el contacto
	 * @param string $msisdn Código de país + número de teléfono del contacto a agregar
     * @return mixed
     */
	public function add_contact($short_name, $msisdn)
	{
		if( empty($short_name) || empty($msisdn) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name/contacts/$msisdn", array('short_name'=>$short_name, 'msisdn'=>$msisdn), 'post', null);
	}

	/**
	 * Elimina un contacto del grupo
     * @param string $short_name Nombre corto del grupo al que se agregará el contacto
     * @param string $msisdn Código de país + número de teléfono del contacto a eliminar del grupo
     * @return mixed
     */
	public function remove_contact($short_name, $msisdn)
	{
		if( empty($short_name) || empty($msisdn) )
			return (object)array('error'=>'Parameters missing');

		return $this->call("groups/$short_name/contacts/$msisdn", array('short_name'=>$short_name, 'msisdn'=>$msisdn), 'delete', null);
	}

}