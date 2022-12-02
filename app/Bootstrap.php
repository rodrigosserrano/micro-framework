<?php
require '../vendor/autoload.php';
session_start();

use App\core\router\Router;

Router::run();