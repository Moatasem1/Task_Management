<?php

namespace Models;

require_once "../helpers/utility.php";
require_once "tasks_managements_db.php";

use Helpers\Utility;
use Models\TasksManagementsDB;
use PDO;

class Task
{
    private int $taskId;
    private string $taskName;
    private TasksManagementsDB $db;

    public function __construct(TasksManagementsDB $db, string $taskName)
    {
        $this->db = $db;
        $this->taskName = Utility::cleanInput($taskName);
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getTaskName(): string
    {
        return $this->taskName;
    }

    public function setTaskName(string $taskName): void
    {
        $this->taskName = $taskName;
    }

    public function saveTask(int $userId): bool
    {
        $sql = "INSERT into tasks (task_name,user_id) values (:task_name,:user_id);";
        $stmt =  $this->db->excuteQuery($sql, [':task_name' => $this->taskName, ':user_id' => $userId]);

        $this->taskId = $this->db->getLastInsertId();

        if ($stmt->rowCount() > 0)
            return true;

        return false;
    }
}
