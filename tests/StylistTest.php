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

    class StylistTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function testGetClients()
        {
            $name = "Barbara Styler";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $test_stylist_id = $test_stylist->getId();
            $appointment = '0000-00-00';

            $description = "Johnny Longhair";
            $test_client = new Client($description, $id, $test_stylist_id, $appointment);
            $test_client->save();

            $description2 = "Melissa Afro";
            $test_client2 = new Client($description2, $id, $test_stylist_id, $appointment);
            $test_client2->save();

            $result = $test_stylist->getClients();

            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_getName() {
            $name = "Barbara Styler";
            $test_stylist = new Stylist($name);

            $result = $test_stylist->getName();

            $this->assertEquals($name, $result);
        }

        function test_save() {
            $name = "Barbara Styler";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $result = Stylist::getAll();

            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll() {
            $name = "Barbara Styler";
            $name2 = "Mr. Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            $result = Stylist::getAll();

            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll() {
            $name = "Wash the dog";
            $name2 = "Mr. Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            Stylist::deleteAll();
            $result = Stylist::getAll();

            $this->assertEquals([], $result);
        }

        function test_find() {
            $name = "Wash the dog";
            $name2 = "Mr. Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            $result = Stylist::find($test_stylist->getId());

            $this->assertEquals($test_stylist, $result);
        }

        function test_changeName() {
            $name = "Barabababa Styliste";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $new_name = "Barbara Styler";

            $test_stylist->changeName($new_name);
            $result = $test_stylist->getName();

            $this->assertEquals("Barbara Styler", $result);
        }
    }

?>
