<?php
//Désactive l'affichage d'erreur
//ini_set('display_errors','off');
error_reporting(E_ALL);
//Création du ROOT
$directory = basename(dirname(dirname(__FILE__)));
$url = explode($directory, $_SERVER['REQUEST_URI']);
if (count($url) == 1)
    define('ROOT', '/');
else
    define('ROOT', $url[0] . 'sudokuSolver/');
