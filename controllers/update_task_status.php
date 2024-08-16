<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PATCH');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once "../models/task.php";
require_once "../models/tasks_managements_db.php";
require_once "../config/db_config.php";

use Models\Task;
use Models\TasksManagementsDB;

function respond($success)
{
    $response = [
        'success' => $success
    ];
    echo json_encode($response);
    exit();
}

$userInput  = file_get_contents('php://input');
$userData = json_decode($userInput, true);

if (!isset($userData['taskId']) || !isset($userData['newTaskStatus']) || !isset($userData['userId'])) {
    respond(false, 0, 'Invalid input');
}

try {
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $task = new Task($db, '', $userData['taskId']);
    $result = $task->updateTaskStatus($userData['newTaskStatus'], $userData['userId']);

    if ($result) {
        respond(true);
    } else {
        respond(false);
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
