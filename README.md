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
    $api = new SmsApi(API_KEY, API_SECRET_KEY, API_URL);
```

Para hacer llamadas al API puede utilizarse `contacts()`, `groups()` y `messages()`  en el objeto de api:

```php

    /* I want my responses as objects... did you want arrays? change last parameter to true */ 
    $api = new SmsApi(API_KEY, API_SECRET, API_URL, false);  


    $contacts = $api->contacts()
        ->getContacts('12345678' /* Or a name, it works too */,
        /*limit*/ 10,/* offset */ 0, /* contact status */'SUSCRIBED');

    if ($contacts->status=="OK") /* do something */ ;


    $groups = $api->groups()
        ->getGroups("my group" /*$query*/, 0 /*$limit*/,0 /* $offset */,
         false /*$shortResults*/);

    if ($groups->status=="OK") /* do something */ ;

    
    $message = $api->messages()
        ->sendToContact("50212345678", "Sent from PHP SDK");

    if ($message->status=="OK") echo "Mensaje enviado..."

```

## Ejemplos

Puedes ver ejemplos de todas las funciones en [examples](https://github.com/interactuamovil/im-contactosms-sdk-php/tree/master/examples).


## Documentación

La documentación del SDK PHP se encontra en el wiki: [Ver documentación](https://github.com/interactuamovil/im-contactosms-sdk-php/wiki)