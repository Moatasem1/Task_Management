<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once "../models/task.php";
require_once "../models/tasks_managements_db.php";
require_once "../config/db_config.php";

use Models\Task;
use Models\TasksManagementsDB;

function respond($success, $taskId = 0, $message = '')
{
    $response = [
        'success' => $success,
        'message' => $message,
        'task_id' => $taskId,
    ];
    echo json_encode($response);
    exit();
}

$userInput  = file_get_contents('php://input');
$userData = json_decode($userInput, true);

if (!isset($userData['task_name']) || !isset($userData['user_id'])) {
    respond(false, 0, 'Invalid input');
}

try {
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $task = new Task($db, $userData["task_name"]);
    $result = $task->saveTask($userData['user_id']);

    if ($result) {
        respond(true, $task->getTaskId(), 'task saved');
    } else {
        respond(false, 0, "can't save the task");
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
