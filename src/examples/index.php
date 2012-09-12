<?php

include('settings.php');
include('../SmsApi.php');

$examples = array(
    'accounts' => 'AccountsExample',
    'contacts' => 'ContactsExample',
    'groups' => 'GroupsExample',
    'messages' => 'MessagesExample',
);

if (isset($_GET['example']) && array_key_exists($_GET['example'], $examples)) {
    $example_name = $_GET['example'];
    include("$example_name.php");
    $example = new $examples[$example_name](API_KEY, API_SECRET_KEY, API_URL);
}
else { ?>

<html>
    <head>
        <title>Ejemplos de SDK</title>
    </head>
    <body>
        <h1>Escoge un ejemplo</h1>
        <ul>
            <li><a href="?example=accounts">Cuentas</a></li>
            <li><a href="?example=contacts">Contactos</a></li>
            <li><a href="?example=groups">Grupos</a></li>
            <li><a href="?example=messages">Mensajes</a></li>
        </ul>
    </body>
</html>

<?php

}