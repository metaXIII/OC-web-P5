<?php

use metaxiii\sudokuSolver\Router;

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
    if (!userIsConnected()) {
        header("Location:" . ROOT);
    }
    include "view/admin/admin.php";
});
$router->get('/admin/new-grid', function () {
    if (!userIsConnected()) {
        header("Location:" . ROOT);
    }
    include "view/admin/grid.php";
});
$router->post('/admin/new-grid', function () {
    if (!userIsConnected()) {
        header("Location:" . ROOT);
    }
    include "view/admin/grid.php";
});
$router->get('/admin/grid', function () {
    if (!userIsConnected()) {
        header("Location:" . ROOT);
    }
    include "view/admin/grid.php";
});
$router->post('/admin/grid', function () {
    if (!userIsConnected()) {
        header("Location:" . ROOT);
    }
    include "view/admin/grid.php";
});
$router->get("/error", function () {
    include "view/public/error404.php";
});

$router->run();
