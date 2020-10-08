<?php

namespace App\Composer;

class ComposerRequest
{
    private $composerDataAccess;

    public function __construct($composerDataAccess)
    {
        $this->composerDataAccess = $composerDataAccess;
    }

    public function getAll()
    {
        return $this->composerDataAccess->getAll();
    }

    public function getById(int $id)
    {
        return $this->composerDataAccess->getById($id);
    }

    public function createComposer(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $decoded = json_decode($request->getBody());
        $firstName = $decoded->firstName;
        $lastName = $decoded->lastName;
        $bestWorks = $decoded->bestWorks;
        return $this->composerDataAccess->createComposer($firstName, $lastName, $bestWorks);
    }

    public function updateComposer(int $id, \Psr\Http\Message\ServerRequestInterface $request)
    {
        $decoded = json_decode($request->getBody());
        $firstName = $decoded->firstName;
        $lastName = $decoded->lastName;
        $bestWorks = $decoded->bestWorks;
        return $this->composerDataAccess->updateComposer($id, $firstName, $lastName, $bestWorks);
    }
}