<?php

include("../src/IMApi.php");

$api = new IMApi("n90GovNeANyXaZWFkGC3TRhVAByRxrVg", "UE3BY99Kk2BUnfqJAq8YqqNnyy5pZ86Q", "http://localhost:8088/api");

// var_dump($api->contacts()->getContacts());
var_dump($api->contacts()->getContacts('796',10,1,'SUSCRIBED'));
die();
var_dump($api->contacts()->deleteContact("50230292397"));
var_dump($api->contacts()->createContact("30292397","502"));