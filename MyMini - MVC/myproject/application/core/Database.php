<?php

class Database
{
    private $db = null;

    public function __construct(PDO $pdo)
    {
        try{
            $this->db = $pdo;
        } catch(PDOException $e) {
            exit("No tenemos accesible la Base de Datos");
        }
    }

    public function getDatabase()
    {
        return $this->db;
    }
}