<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once "../models/task.php";
require_once "../models/tasks_managements_db.php";
require_once "../config/db_config.php";

use Models\Task;
use Models\TasksManagementsDB;

function respond($success, $tasks)
{
    $response = [
        'success' => $success,
        'tasks' => $tasks
    ];
    echo json_encode($response);
    exit();
}

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if (!isset($user_id)) {
    respond(false, 0, 'Invalid input');
}

try {
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $result = Task::getAllTasks($db, $user_id);

    if ($result) {
        respond(true, $result);
    } else {
        respond(false, null);
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
