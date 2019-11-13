<?php

session_start();
define('URL', str_replace("index.php", "",(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

//Toutes les requêtes du site commence ici
require_once('controllers/Router.php');
new Router();