<?php
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('event_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['name'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['App\Composer\ComposerDataAccess'] = function ($c) {
    $db = $c->get('db');
    return new App\Composer\ComposerDataAccess($db);
};

$container['App\Composer\ComposerRequest'] = function ($c) {
    $dataAccess = $c->get('App\Composer\ComposerDataAccess');
    return new App\Composer\ComposerRequest($dataAccess);
};
