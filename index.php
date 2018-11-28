<?php
use metaxiii\sudokuSolver\Autoloader;

require 'controller/list.php';
require 'model/Autoloader.php';

Autoloader::register();

require "controller/routes.php";



