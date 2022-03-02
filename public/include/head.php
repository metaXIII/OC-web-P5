<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Blog pour écrivain</title>
        <link rel="stylesheet" href="<?= ROOT ?>vendor/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?= ROOT ?>public/css/style.css" type="text/css">
    </head>

    <body>

        <header>
            <nav class="navbar navbar-dark bg-dark">
                <ul class="nav">
                    <li>
                        <a class="navbar-brand" href="<?= ROOT ?>">Accueil</a>
                    </li>
                </ul>
                <ul class="nav navbar-right">
                    <?php if (isset($_SESSION['Auth']) && $_SESSION['Auth']) {
                        ?>
                        <li class="p-1">
                            <a class="nav-item text-white" href='<?= ROOT ?>admin'>Mon espace</a>
                        </li>
                        <li class="p-1">
                            <a class="nav-item text-white" href='<?= ROOT ?>logout'>Se déconnecter</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="p-1">
                            <a class="nav-item text-white" href="<?= ROOT ?>signin">Créer un compte</a>
                        </li>
                        <li class="p-1">
                            <a class="nav-item text-white" href="<?= ROOT ?>login">Se connecter</a>
                        </li>
                        <?php
                    } ?>
                </ul>
            </nav>
        </header>

        <?= flash() ?>

