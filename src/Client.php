<?php
    class Client {
        private $description;
        private $stylist_id;
        private $id;
        private $appointment;

        function __construct($description, $id = null, $stylist_id, $appointment) {
            $this->description = $description;
            $this->id = $id;
            $this->stylist_id = $stylist_id;
            $this->appointment = $appointment;
        }

        function setDescription($description) {
            $this->description = (string) $description;
        }

        function getDescription() {
            return $this->description;
        }

        function getId() {
            return $this->id;
        }

        function getStylistId() {
            return $this->stylist_id;
        }

        function setAppointment($appointment) {
            $this->appointment = $appointment;
        }

        function getAppointment() {
            return $this->appointment;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO clients (description, stylist_id, appointment) VALUES ('{$this->getDescription()}', {$this->getStylistId()}, '{$this->getAppointment()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client) {
                $description = $client['description'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $appointment = $client["appointment"];
                $new_client = new Client($description, $id, $stylist_id, $appointment);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        static function find($search_id) {
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        function changeDescription($new_description) {
            $GLOBALS['DB']->exec("UPDATE clients SET description = '{$new_description}' WHERE id = {$this->getId()};");
            $this->setDescription($new_description);
        }

        function deleteOne() {
            $GLOBALS["DB"]->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }

    }
?>
