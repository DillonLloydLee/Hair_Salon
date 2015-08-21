<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getId() {
            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment);
            $test_client->save();

            $result = $test_client->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId() {
            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment);
            $test_client->save();

            $result = $test_client->getStylistId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_save() {
            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment);

            $test_client->save();

            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }
        function test_getAll() {
            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment);
            $test_client->save();

            $description2 = "Melissa Afro";
            $test_client2 = new Client($description2, $id, $stylist_id, $appointment);
            $test_client2->save();

            $result = Client::getAll();

            $this->assertEquals([$test_client, $test_client2], $result);
        }
        function test_deleteAll() {

            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment);
            $test_client->save();

            $description2 = "Melissa Afro";
            $test_client2 = new Client($description2, $id, $stylist_id, $appointment);
            $test_client2->save();

            Client::deleteAll();

            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function test_find() {
            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment);
            $test_client->save();

            $description2 = "Melissa Afro";
            $test_client2 = new Client($description2, $id, $stylist_id, $appointment);
            $test_client2->save();

            $result = Client::find($test_client->getId());

            $this->assertEquals($test_client, $result);
        }

        function test_getAppointment() {
            $name = "Barbara Styler";
            $id = null;
            $appointment = '0000-00-00';
            $appointment = "1984-02-32";
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $description = "Johnny Longhair";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($description, $id, $stylist_id, $appointment, $appointment);
            $test_client->save();

            $result = $test_client->getAppointment();

            $this->assertEquals("1984-02-32", $result);
        }

    }















 ?>
