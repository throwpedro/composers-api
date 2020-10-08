<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once('routes-composers.php');

$app->get('/ping', function (Request $request, Response $response, array $args) {
    $this->logger->warning('The api was pinged.');
    return $response->withJson(array('ping' => 'the api is alive and kicking', 'time' => date('Y-m-d H:i:s')));
});