<?php

//later create web interfece with up and down choic and filename submite for down choice

require_once "../models/tasks_managements_db.php";

use Models\TasksManagementsDB;

class Migration
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    private function getMigrationFiles()
    {
        $files = glob(__DIR__ . '/migration_files/*.php');
        sort($files);
        return $files;
    }

    private function getAppliedMigrations()
    {
        $stmt = $this->connection->query("SELECT migration FROM migrations");
        // use FETCH_COLUMN to get just the value without the col name
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function applyMigration($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Migration file does not exist: $file");
        }

        require_once $file;

        $migrationName = basename($file, '.php');

        $this->connection->beginTransaction();
        // up function may have multiple opeation

        try {
            up($this->connection);
            $stmt = $this->connection->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->execute([$migrationName]);
            $this->connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }

    private function createMigrationTable()
    {
        $this->connection->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function migrateAllUp()
    {
        $this->createMigrationTable();

        $migrationFiles = $this->getMigrationFiles();
        $appliedMigrations = $this->getAppliedMigrations();


        foreach ($migrationFiles as $file) {
            $migrationName = basename($file, '.php');
            if (!in_array($migrationName, $appliedMigrations)) {
                $this->applyMigration($file);
            }
        }
    }

    public function migrateFileDown($fileName)
    {
        $this->createMigrationTable();
        $migrationFile = __DIR__ . '/migration_files/' . $fileName . '.php';

        if (!file_exists($migrationFile)) {
            throw new Exception("Migration file does not exist: $migrationFile");
        }

        $this->connection->beginTransaction();
        try {
            down($this->connection);

            $stmt = $this->connection->prepare("DELETE FROM migrations WHERE migration = ?");
            $stmt->execute([$fileName]);
            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}

require_once "../config/db_config.php";
$db = new TasksManagementsDB($host, $dbname, $username, $password);
$connection = $db->getConnection();
$migrate = new Migration($connection);
$migrate->migrateAllUp();
echo "hello";
