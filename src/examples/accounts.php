<?php

include('base.php');

/**
 * Ejemplos de API para información de cuenta
 */
class AccountsExample extends BaseExample {

    public function run() {

        $this->title = 'Estado de la cuenta';

        $status = $this->api->account->status();

        pre('Nombre de la cuenta: '.$status->name);
        pre('Nombre corto SMS: '.$status->sms_short_name);
        pre('Tipo de Suscripcion SMS: '.$status->sms_subscription_type);
        if ($status->sms_subscription_type == 'OPTIN') {
            pre('Keyword de Opt-In: '.$status->sms_optin_keyword);
        }
        pre('Limite de mensajes: '.$status->messages_limit);
        pre('Mensajes enviados: '.$status->messages_sent);

    }

}