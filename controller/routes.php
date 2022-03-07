<?php

    use metaxiii\sudokuSolver\Router;
    use metaxiii\sudokuSolver\RouterException;


    function checkUserConnected(): void {
        if (!userIsConnected()) {
            header("Location:" . ROOT);
        }
    }

    function viewAdminGrid(): void {
        include "view/admin/grid.php";
    }

    $router = new Router($_GET['url']);
    $router->get('/', function () {
        include "view/public/accueil.php";
    });
    $router->post('/', function () {
        include "view/public/accueil.php";
    });
    $router->get('/login', function () {
        include "view/public/login.php";
    });
    $router->post('/login', function () {
        include "view/public/login.php";
    });
    $router->get('/signin', function () {
        include "view/public/signin.php";
    });
    $router->post('/signin', function () {
        include "view/public/signin.php";
    });
    $router->get('/logout', function () {
        include "view/public/logout.php";
    });
    $router->get('/admin', function () {
        checkUserConnected();
        include "view/admin/admin.php";
    });
    $router->get('/admin/new-grid', function () {
        checkUserConnected();
        viewAdminGrid();
    });
    $router->post('/admin/new-grid', function () {
        checkUserConnected();
        viewAdminGrid();
    });
    $router->get('/admin/grid', function () {
        checkUserConnected();
        viewAdminGrid();
    });
    $router->post('/admin/grid', function () {
        checkUserConnected();
        viewAdminGrid();
    });
    $router->get("/error", function () {
        include "view/public/error404.php";
    });

    try {
        $router->run();
    } catch (RouterException $e) {
        print($e->getMessage());
    }
