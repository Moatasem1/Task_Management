<?php

namespace Models;

use PDO;
use PDOException;

require_once "../config/db_config.php";

class TasksManagementsDB
{
    private $connection;

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            //need to change
            echo "Connection failed: " . $exception->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        $this->connection = null;
    }

    public function excuteQuery($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();

            return $stmt;
        } catch (PDOException $exception) {
            throw new \Exception("Database query failed.");
        }
    }

    public function fetchQueryStatment($stmt, $fetchMode = PDO::FETCH_ASSOC)
    {
        if (!empty($stmt)) {
            $result = $stmt->fetchAll($fetchMode);

            return $result;
        }

        return null;
    }

    function getLastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
