InteractúaMóvil SDK PHP
=======================

SDK PHP para el API SMS de InteractúaMóvil.

Es necesario poseer un **API_KEY**, un **API_SECRET_KEY** y **API_URL**
para utilizar el API.

Ejemplo de creación de instancia del api:

    require 'im-sdk-php/src/SmsApi.php';
    $this->api = new SmsApi(API_KEY, API_SECRET_KEY, API_URL);
    $contacts = $this->api->contacts->get_list();