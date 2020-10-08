<?php

namespace App\Composer;

class ComposerDataAccess
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM `composers`");
        $composers = $stmt->fetchAll();
        return $composers;
    }

    public function getById(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM `composers`
            WHERE `id` = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function createComposer(string $firstName, string $lastName, string $bestWorks)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO `composers`
            SET `first_name` = :firstName,
                `last_name` = :lastName,
                `best_works` = :bestWorks"
        );
        $stmt->execute([':firstName' => $firstName, ':lastName' => $lastName, ':bestWorks' => $bestWorks]);
        return $this->db->lastInsertId();
    }

    public function updateComposer(int $id, ?string $firstName, ?string $lastName, ?string $bestWorks)
    {
        $queryAndBinds = $this->buildUpdateQuery($id, $firstName, $lastName, $bestWorks);
        if ($queryAndBinds) {
            $stmt = $this->db->prepare(
                $queryAndBinds['query']
            );
            return $stmt->execute($queryAndBinds['binds']);
        }
        return 'Nothing to update';
    }

    private function buildUpdateQuery(int $id, ?string $firstName, ?string $lastName, ?string $bestWorks)
    {
        $query = [];
        $binds = [];
        if (!empty($firstName)) {
            $query[] = 'first_name = :firstName';
            $binds['firstName'] = $firstName;
        }
        if (!empty($lastName)) {
            $query[] = 'last_name = :lastName';
            $binds['lastName'] = $lastName;
        }
        if (!empty($bestWorks)) {
            $query[] = 'best_works = :bestWorks';
            $binds['bestWorks'] = $bestWorks;
        }

        empty($query) ? null : $sql = 'UPDATE `composers` SET ' . implode(', ', $query) . ' WHERE id = :id';
        $binds['id'] = $id;
        return empty($sql) ? false : ['query' => $sql, 'binds' => $binds];
    }
}