<?php

    use metaxiii\sudokuSolver\Router;
    use metaxiii\sudokuSolver\RouterException;

    $router = new Router($_GET['url']);
    $router->get('/', function () {
        include "view/public/accueil.php";
    });
    $router->post('/', function () {
        include "view/public/accueil.php";
    });
    $router->get("/error", function () {
        include "view/public/error404.php";
    });

    try {
        $router->run();
    } catch (RouterException $e) {
        print($e->getMessage());
    }
