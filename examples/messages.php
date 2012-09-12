<?php

include('base.php');

/**
 *
 */
class MessagesExample extends BaseExample {

    function run() {

        $messages_examples = array(
            '_list',
            '_list_contact',
            'single',
            'group',
        );

        if (!empty($_GET['messages_example'])
            && in_array($_GET['messages_example'], $messages_examples)) {
            $this->{$_GET['messages_example']}();
        }
        else {
            include('includes/messages/examples.php');
        }

    }

    private function get_list($msisdn=null) {

        $today = date('Y-m-d');
        $month_ago = date('Y-m-d', strtotime('-30 day', strtotime($today)));
        $messages = $this->api->messages->get_list($month_ago, $today, 0, 10, $msisdn);

        if (!empty($messages)) {
            if (isset($messages->error)) {
                error('Error: '.$messages->error);
            } else {
                $i = 1;
                foreach ($messages as $message) {
                    pre('Mensaje: '.$message->message);
                    pre('Fecha: '.$message->sent_on);
                    pre('Enviado por: '.$message->username);
                    pre('Total enviados: '.$message->recipients_count);
                    hr();
                    $i++;
                }
            }
        }
        else {
            error('No hay mensajes.');
        }

    }

    public function _list() {
        $this->get_list();
    }

    public function _list_contact() {

        if (!empty($_POST['msisdn'])) {
            $this->get_list(COUNTRY_CODE.$_POST['msisdn']);
        }
        else {
            include('includes/messages/contact.php');
        }

    }

    public function single() {

        if (!empty($_POST['msisdn']) && !empty($_POST['message'])) {

            $sent = $this->api->messages->send_to_contact(COUNTRY_CODE.$_POST['msisdn'], $_POST['message']);

            if (isset($sent->error)) {
                error('Error: '.$sent->error);
            } else {
                pre('Mensaje enviado!', 'green');
            }

        }
        else {
            include('includes/messages/single.php');
        }

    }

    public function group() {

        if (!empty($_POST['short_name']) && !empty($_POST['message'])) {

            $sent = $this->api->messages->send_to_groups(array($_POST['short_name']), $_POST['message']);

            if (isset($sent->error)) {
                error('Error: '.$sent->error);
            } else {
                pre('Mensaje enviado!', 'green');
            }

        }
        else {
            include('includes/messages/group.php');
        }

    }

}