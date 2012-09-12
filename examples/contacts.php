<?php

include('base.php');

/**
 *
 */
class ContactsExample extends BaseExample {

    function run() {

        $contacts_examples = array(
            '_list',
            '_list_confirmed',
            '_list_pending',
            '_list_cancelled',
            'add',
            'update',
            'delete'
        );

        if (!empty($_GET['contacts_example'])
            && in_array($_GET['contacts_example'], $contacts_examples)) {
            $this->{$_GET['contacts_example']}();
        }
        else {
            include('includes/contacts/examples.php');
        }

    }

    /**
     * @param $contacts
     */
    private function list_contacts($contacts) {

        if (!empty($contacts)) {
            $i = 1;
            foreach($contacts as $contact) {
                $class = 'red';
                if ($contact->status === '1') {
                    $class = 'green';
                }
                else if ($contact->status === '0') {
                    $class = 'yellow';
                }
                else if ($contact->status === '2') {
                    $class = 'red';
                }
                echo "<h3 class='$class'>$i) {$contact->msisdn}</h3>";
                pre('Primer nombre: '.$contact->first_name);
                pre('Segundo nombre: '.$contact->last_name);
                pre('Estado: '.$contact->status);
                $i++;
            }
        }
        else {
            error('No hay contactos.');
        }

    }

    function _list() {

        $this->list_contacts($this->api->contacts->get_list());

    }

    function _list_confirmed() {

        $this->list_contacts($this->api->contacts->get_list(
            $this->api->contacts->CONFIRMED
        ));

    }

    function _list_pending() {

        $this->list_contacts($this->api->contacts->get_list(
            $this->api->contacts->PENDING
        ));

    }

    function _list_cancelled() {

        $this->list_contacts($this->api->contacts->get_list(
            $this->api->contacts->CANCELLED
        ));

    }

    function add() {

        if(!empty($_POST['msisdn'])) {

            $first_name = isset($_POST['first_name']) && !empty($_POST['first_name']) ? $_POST['first_name'] : null;
            $last_name = isset($_POST['last_name']) && !empty($_POST['last_name']) ? $_POST['last_name'] : null;

            $added = $this->api->contacts->add(
                COUNTRY_CODE.$_POST['msisdn'],
                $first_name,
                $last_name
            );

            if (empty($added) || !empty($added->error)) {
                pre('Error: '.$added->error, 'red');
            }
            else {
                pre($added->result, 'green');
            }

        }
        else {
            include('includes/contacts/add.php');
        }

    }

    function update() {

        if(!empty($_POST['msisdn'])) {

            $first_name = isset($_POST['first_name']) && !empty($_POST['first_name']) ? $_POST['first_name'] : null;
            $last_name = isset($_POST['last_name']) && !empty($_POST['last_name']) ? $_POST['last_name'] : null;

            $updated = $this->api->contacts->update(
                COUNTRY_CODE.$_POST['msisdn'],
                $first_name,
                $last_name
            );

            if (empty($updated) || !empty($updated->error)) {
                pre('Error: '.$updated->error, 'red');
            }
            else {
                pre($updated->result, 'green');
            }

        }
        else {
            include('includes/contacts/update.php');
        }

    }

    function delete() {

        if(!empty($_POST['msisdn'])) {

            $deleted = $this->api->contacts->delete(
                COUNTRY_CODE.$_POST['msisdn']
            );

            if (empty($deleted) || !empty($deleted->error)) {
                pre('Error: '.$deleted->error, 'red');
            }
            else {
                pre($deleted->result, 'green');
            }

        }
        else {
            include('includes/contacts/delete.php');
        }


    }

}