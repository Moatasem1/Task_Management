<?php

header('Content-Type: application/json');
require_once "../models/sing_up.php";
require_once "../models/user.php";
require_once "../models/tasks_managements_db.php";
require_once "../config/db_config.php";

use Models\SingUp;
use Models\User;
use Models\TasksManagementsDB;

function respond($success, $message)
{
    $response = [
        'success' => $success,
        'message' => $message,
    ];
    echo json_encode($response);
    exit();
}

$userInput  = file_get_contents('php://input');
$userData = json_decode($userInput, true);

if (!isset($userData['username']) || !isset($userData['password'])) {
    respond(false, 'Invalid input');
}

$db = new TasksManagementsDB($host, $dbname, $username, $password);
$user = new User($db, $userData["username"], $userData["password"]);
$signUp = new SingUp($user);
$result = $signUp->register();

if ($result === null) {
    respond(true, '');
    echo "done successfully";
} else {
    respond(false, $result);
    echo "something go wrong";
}
