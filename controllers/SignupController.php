<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once "../models/sing_up.php";
require_once "../models/user.php";
require_once "../models/tasks_managements_db.php";
require_once "../config/db_config.php";

use Models\SingUp;
use Models\User;
use Models\TasksManagementsDB;

function respond($success, $message = '', $username = '', $userId = null)
{
    $response = [
        'success' => $success,
        'message' => $message,
        'username' => $username,
        'userId' => $userId
    ];

    echo json_encode($response);
    exit();
}

$userInput  = file_get_contents('php://input');
$userData = json_decode($userInput, true);

if (!isset($userData['username']) || !isset($userData['password'])) {
    respond(false, 'Invalid input');
}

try {
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $user = new User($db, $userData["username"], $userData["password"]);
    $signUp = new SingUp($user);
    $result = $signUp->register();

    if ($result === null) {
        $_SESSION["isauthenticat"] = true;
        respond(true, '', $user->getUserName(), $user->getUserId());
    } else {
        respond(false, $result);
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
