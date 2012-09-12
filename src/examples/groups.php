<?php

include('base.php');

/**
 *
 */
class GroupsExample extends BaseExample {

    function run() {

        $groups_examples = array(
            '_list',
            'add',
            'add_contact',
            'update',
            'delete',
            'single'
        );

        if (!empty($_GET['groups_example'])
            && in_array($_GET['groups_example'], $groups_examples)) {
            $this->{$_GET['groups_example']}();
        }
        else {
            include('includes/groups/examples.php');
        }

    }

    public function _list() {

        $groups = $this->api->groups->get_list();

        if (!empty($groups)) {
            $i = 1;
            foreach ($groups as $group) {
                echo "<h3>$i) {$group->name}</h3>";
                pre('Nombre corto SMS: '.$group->short_name);
                pre('Descripción: '.$group->description);
                pre('Total contactos: '.$group->members->total);
                pre('Total confirmados: '.$group->members->confirmed, 'green');
                pre('Total pendientes: '.$group->members->pending, 'yellow');
                pre('Total cancelados: '.$group->members->cancelled, 'red');
                $i++;
            }
        }
        else {
            error('No hay grupos.');
        }

    }

    public function single() {

        if(!empty($_POST['short_name'])) {

            $group = $this->api->groups->get($_POST['short_name']);

            if (!empty($group)) {

                echo "<h3>{$group->name}</h3>";
                pre('Nombre corto SMS: '.$group->short_name);
                pre('Descripción: '.$group->description);
                pre('Total de contactos: '.$group->members->total);
                pre('Confirmados: '.$group->members->confirmed, 'green');
                pre('Pendientes: '.$group->members->pending, 'yellow');
                pre('Cancelados: '.$group->members->pending, 'red');
                echo "<h3>Contactos</h3>";

                $contacts = $this->api->groups->get_contact_list(
                    $group->short_name);

                if (!empty($contacts)) {
                    $i = 1;
                    foreach ($contacts as $contact) {
                        $class = '';
                        if ($contact->status === '1') {
                            $class = 'green';
                        }
                        else if ($contact->status === '0') {
                            $class = 'yellow';
                        }
                        else if ($contact->status === '2') {
                            $class = 'red';
                        }
                        pre('Contacto: '.$contact->msisdn, $class);
                        $i++;
                    }

                }

            }
            else {
                error('El grupo no se encontró.');
            }

        }
        else {
            include('includes/groups/single.php');
        }

    }

    public function add() {

        if(!empty($_POST['name']) && !empty($_POST['short_name'])) {

            $description = isset($_POST['description']) && !empty($_POST['description']) ? $_POST['description'] : null;

            $added = $this->api->groups->add(
                $_POST['short_name'],
                $_POST['name'],
                $description
            );

            if (empty($added) || !empty($added->error)) {
                pre('Error: '.$added->error, 'red');
            }
            else {
                pre($added->result, 'green');
            }

        }
        else {
            include('includes/groups/add.php');
        }

    }

    public function update() {

        if(!empty($_POST['name']) && !empty($_POST['short_name'])) {

            $description = isset($_POST['description']) && !empty($_POST['description']) ? $_POST['description'] : null;

            $updated = $this->api->groups->update(
                $_POST['short_name'],
                $_POST['name'],
                $description
            );

            if (empty($updated) || !empty($updated->error)) {
                pre('Error: '.$updated->error, 'red');
            }
            else {
                pre($updated->result, 'green');
            }

        }
        else {
            include('includes/groups/update.php');
        }

    }

    public function delete() {

        if(!empty($_POST['short_name'])) {

            $deleted = $this->api->groups->delete(
                $_POST['short_name']
            );

            if (empty($deleted) || !empty($deleted->error)) {
                pre('Error: '.$deleted->error, 'red');
            }
            else {
                pre($deleted->result, 'green');
            }

        }
        else {
            include('includes/groups/delete.php');
        }

    }

    public function add_contact() {

        if(!empty($_POST['short_name']) && !empty($_POST['msisdn'])) {

            if(!empty($_POST['short_name']) && !empty($_POST['msisdn'])) {

                $added = $this->api->groups->add_contact($_POST['short_name'], COUNTRY_CODE.$_POST['msisdn']);

                if (empty($added) || !empty($added->error)) {
                    pre('Error: '.$added->error, 'red');
                }
                else {
                    pre($added->result, 'green');
                }

            }
            else {
                error('Ingresar el nombre corto del grupo y número de teléfono.');
            }

        }
        else {
            include('includes/groups/contact.php');
        }

    }

}