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

// Function to respond with JSON
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

// Function to verify reCAPTCHA token
require_once "../helpers/authenticate.php";

// Get and decode JSON input
$userInput  = file_get_contents('php://input');
$userData = json_decode($userInput, true);


if (
    !isset($userData['username']) || !isset($userData['password']) ||
    !isset($userData["email"]) || !isset($userData["recaptcha_response"])
) {
    respond(false, 'Invalid input');
}

// Verify reCAPTCHA token
if (!verifyRecaptcha($userData['recaptcha_response'])) {
    respond(false, 'reCAPTCHA verification failed');
}

try {
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $user = new User($db, $userData["username"], $userData["password"]);
    $user->setEmail($userData["email"]);
    $signUp = new SingUp($user);
    $result = $signUp->register();

    if ($result === null) {
        $_SESSION["isRegister"] = true;
        respond(true, '', $user->getUserName(), $user->getUserId());
    } else {
        respond(false, $result);
    }
} catch (Exception $e) {
    respond(false, "An error occurred: " . $e->getMessage());
}
