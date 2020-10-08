<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/composers', function () use ($app) {
    $app->get('', function (Request $request, Response $response, array $args) {
        $req = $this->get('App\Composer\ComposerRequest');
        return $response->withJson($req->getAll());
    });

    $app->get('/{id}', function (Request $request, Response $response, array $args) {
        $req = $this->get('App\Composer\ComposerRequest');
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');
        return $response->withJson($req->getById((int)$id));
    });

    $app->post('', function (Request $request, Response $response, array $args) {
        $req = $this->get('App\Composer\ComposerRequest');
        $insertId = $req->createComposer($request);
        $newResponse = $response->withStatus(201);
        $newResponse = $response->withJson(['id' => $insertId]);
        return $newResponse;
    });

    $app->patch('/{id}', function (Request $request, Response $response, array $args) {
        $req = $this->get('App\Composer\ComposerRequest');
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');
        return $response->withJson($req->updateComposer($id, $request));
    });
});
