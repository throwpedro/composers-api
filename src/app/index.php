<?php
require '../vendor/autoload.php';


$config = include('../config.php');
$app = new \Slim\App(['settings' => $config]);

require_once('ioc.php');
require_once('routes.php');

$app->run();
