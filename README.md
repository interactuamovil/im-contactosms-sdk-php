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

```
Ejemplos de llamadas al API:

```php

    $contacts = $api->contacts()
        ->getContacts('12345678' /* Or a name, it works too */,
        /*limit*/ 10,/* offset */ 0, /* contact status */'SUSCRIBED');

    if ($contacts->ok) /* do something */ ;


    $groups = $api->groups()
        ->getGroups("my group" /*$query*/, 0 /*$limit*/,0 /* $offset */,
         false /*$shortResults*/);

    if ($groups->ok) /* do something */ ;

    
    $message = $api->messages()
        ->sendToContact("50212345678", "Sent from PHP SDK");

    if ($message->ok) echo "Mensaje enviado..."

```

## Ejemplos

Puedes ver ejemplos de todas las funciones en [examples](https://github.com/interactuamovil/im-contactosms-sdk-php/tree/master/examples).


## Documentación

La documentación del SDK PHP se encontra en el wiki: [Ver documentación](https://github.com/interactuamovil/im-contactosms-sdk-php/wiki)