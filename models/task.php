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

    private string $taskStatus;

    public function __construct(TasksManagementsDB $db, string $taskName, int $taskId = 0)
    {
        $this->db = $db;
        $this->taskName = Utility::cleanInput($taskName);
        $this->taskId = $taskId;
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

    public function getTaskStatus(): string
    {
        return $this->taskStatus;
    }

    public function setTaskStatus(string $taskStatus): void
    {
        $this->taskStatus = $taskStatus;
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

    static public function getAllTasks(TasksManagementsDB $db, int $userId)
    {
        $sql = "SELECT id,task_name,status from tasks where user_id = :user_id";
        $stmt =  $db->excuteQuery($sql, [':user_id' => $userId]);

        return $db->fetchQueryStatment($stmt);
    }

    public function updateTaskName(int $userID)
    {
        $sql = "UPDATE tasks SET task_name = :task_name where id = :task_id and user_id = :user_id";
        $stmt =  $this->db->excuteQuery($sql, [':task_name' => $this->taskName, ':task_id' => $this->taskId, ":user_id" => $userID]);

        if ($stmt->rowCount() > 0)
            return true;

        return false;
    }

    public function updateTaskStatus(string $newTaskStatus, int $userId)
    {
        $sql = "UPDATE tasks SET status = :status where id = :task_id and user_id = :user_id";
        $stmt =  $this->db->excuteQuery($sql, [':status' => $newTaskStatus, ':task_id' => $this->taskId, ":user_id" => $userId]);

        if ($stmt->rowCount() > 0)
            return true;

        return false;
    }

    public function deleteTask(int $userId)
    {
        $sql = "DELETE FROM tasks where id = :task_id and user_id = :user_id";
        $stmt =  $this->db->excuteQuery($sql, [':task_id' => $this->taskId, ":user_id" => $userId]);

        if ($stmt->rowCount() > 0)
            return true;

        return false;
    }

    static public function deleteAllTasks(TasksManagementsDB $db, int $userId)
    {
        $sql = "DELETE FROM tasks where user_id = :user_id";
        $stmt = $db->excuteQuery($sql, [":user_id" => $userId]);

        if ($stmt->rowCount() > 0)
            return true;

        return false;
    }
}


// require_once '../config/db_config.php';

// $db = new TasksManagementsDB($host, $dbname, $username, $password);
// $task = new Task($db, "", 91);
// echo $task->updateTaskStatus('1', 23);
