# InteractúaMóvil SDK PHP

SDK PHP para el API SMS de InteractúaMóvil.

Es necesario poseer un **API_KEY**, un **API_SECRET_KEY** y **API_URL**
para utilizar el API.

## Requerimientos
* PHP >= 5.1.2
* PECL hash >= 1.1

Ejemplo de creación de instancia del api:
    
```php
    require 'im-contactosms-sdk-php/src/SmsApi.php';

    
    /* I want my responses as objects... did you want arrays? 
        change last parameter to true */ 
    $api = new SmsApi(API_KEY, API_SECRET, API_URL, false);  

```

Para hacer llamadas al API pueden utilizarse los métodos `contacts()`, `groups()` y `messages()`  en el objeto de api, el formato de la respuesta es:

```php

    (array/StdObj) response
    [
        status => (string)"OK",
        ok => (boolean)true,
        code => (int)200,
        headers => (array)[/* the headers */]
        data => (array/StdObj)[/*the data*/]
    ];

    // ejemplos
    
    //    object(stdClass) (5) {
    //       ["code"]=>
    //       int(500)
    //       ["status"]=>
    //       string(5) "Error"
    //       ["ok"]=>
    //       bool(false)
    //       ["response_headers"]=>
    //       array(4) {
    //         [0]=>
    //         string(34) "HTTP/1.1 500 Internal Server Error"
    //         [1]=>
    //         string(30) "Content-Type: application/json"
    //         [2]=>
    //         string(42) "Server: ContactoSMS API/3.0 (Simple 5.1.4)"
    //         [3]=>
    //         string(17) "Connection: close"
    //       }
    //       ["data"]=>
    //       object(stdClass)#5 (2) {
    //         ["code"]=>
    //         int(503)
    //         ["error"]=>
    //         string(25) "Error interno. Reintentar"
    //       }
    //     }

    // array(5) {
    //   ["code"]=>
    //   int(200)
    //   ["status"]=>
    //   string(2) "OK"
    //   ["ok"]=>
    //   bool(true)
    //   ["response_headers"]=>
    //   array(4) {
    //     [0]=>
    //     string(15) "HTTP/1.1 200 OK"
    //     [1]=>
    //     string(30) "Content-Type: application/json"
    //     [2]=>
    //     string(42) "Server: ContactoSMS API/3.0 (Simple 5.1.4)"
    //     [3]=>
    //     string(17) "Connection: close"
    //   }
    //   ["data"]=>
    //   array(1) {
    //     [0]=>
    //     array(7) {
    //       ["msisdn"]=>
    //       string(11) "50212345678"
    //       ["status"]=>
    //       string(9) "SUSCRIBED"
    //       ["phone_number"]=>
    //       string(8) "12345678"
    //       ["country_code"]=>
    //       string(3) "502"
    //       ["first_name"]=>
    //       string(7) "Alberto"
    //       ["full_name"]=>
    //       string(7) "Alberto"
    //       ["added_from"]=>
    //       string(8) "WEB_FORM"
    //     }
    //   }
    // }



```
Ejemplos de llamadas al API:

```php

    $contacts = $api->contacts()
        ->getContacts('12345678' /* Or a name, it works too */,
        /*limit*/ 10,/* offset */ 0, /* contact status */'SUSCRIBED');

    if ($response->ok){
        /* Do something */
        echo "Mis contactos son: \n";
        foreach ($response->data as $contact){
            echo "$contact->msisdn : $contact->first_name\n";
        }
    }


    $groups = $api->groups()
        ->getGroups("my group" /*$query*/, 0 /*$limit*/,0 /* $offset */,
         false /*$shortResults*/);

    if ($groups->ok){
        echo "Mis grupos\n";
        foreach ($groups->data as $group){
            echo " Grupo: $group->name, miembros: {$group->members->total}\n";
        }
    }

    
    $message = $api->messages()
        ->sendToContact("50212345678", "Sent from PHP SDK");

    if ($message->ok) echo "Mensaje enviado..."

```

## Ejemplos

Puedes ver ejemplos de todas las funciones en [examples](https://github.com/interactuamovil/im-contactosms-sdk-php/tree/master/examples).


## Documentación

La documentación del SDK PHP se encontra en el wiki: [Ver documentación](https://github.com/interactuamovil/im-contactosms-sdk-php/wiki)