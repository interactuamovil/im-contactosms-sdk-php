InteractúaMóvil SDK PHP
=======================

SDK PHP para el API SMS de InteractúaMóvil.

Es necesario poseer un **API_KEY**, un **API_SECRET_KEY** y **API_URL**
para utilizar el API.

Ejemplo de creación de instancia del api:

    require 'im-sdk-php/src/SmsApi.php';
    $api = new SmsApi(API_KEY, API_SECRET_KEY, API_URL);

Para hacer llamadas al API puede utilizarse `contacts`, `groups`, `messages` y
`account` en el objeto de api:

    $account_status = $api->accounts->status();
    $contacts = $api->contacts->get_list();
    $groups = $api->groups->get_list();
    $messages = $api->messages->get_list();

