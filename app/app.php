<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();
    $app["debug"] = true;

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    date_default_timezone_set("UTC");

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // allows use of _method input.
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // home route.
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig',
            array('stylists' => Stylist::getAll()));
    });

    // add a client route.
    $app->post("/clients", function() use ($app) {
        $description = $_POST["description"];
        $stylist_id = $_POST["stylist_id"];
        $appointment = $_POST["appointment"];
        $client = new Client($description, $id = null,
            $stylist_id, $appointment);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app["twig"]->render("stylist.html.twig",
            array("stylist" => $stylist, "clients" =>
            $stylist->getClients()));
    });

    // particular stylist route.
    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig',
            array('stylist' => $stylist, 'clients' =>
            $stylist->getClients()));
    });

    // delete all clients route.
    $app->post("/deleted_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('index.html.twig',
            array('stylists' => Stylist::getAll()));
    });

    // add a stylist route.
    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST["name"]);
        $stylist->save();
        return $app["twig"]->render("index.html.twig",
            array("stylists" => Stylist::getAll()));
    });

    // delete all stylists route.
    $app->post("/deleted_stylists", function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig',
            array('stylists' => Stylist::getAll()));
    });

    // change a stylist's name form route.
    $app->get("/stylists/{id}/edit", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app["twig"]->render("stylist_edit.html.twig", array("stylist" => $stylist));
    });

    // return with changed stylist name route.
    $app->patch("/stylists/{id}", function($id) use ($app) {
        $name = $_POST["name"];
        $stylist = Stylist::find($id);
        $stylist->changeName($name);
        return $app["twig"]->render("stylist.html.twig", array("stylist" => $stylist, "clients" => $stylist->getClients()));
    });

    // delete a single stylist route.
    $app->delete("/stylist_deleted/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->deleteOne();
        return $app["twig"]->render("stylist_deleted.html.twig", array("stylists" => Stylist::getAll()));
    });

    // delete a single client route.
    $app->delete("/client_deleted/{id}", function($id) use ($app) {
        $client = Client::find($id);
        $client->deleteOne();
        return $app["twig"]->render("client_deleted.html.twig", array("stylists" => Stylist::getAll()));
    });

    return $app;
?>
