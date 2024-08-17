<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once "../models/sing_in.php";
require_once "../models/user.php";
require_once "../models/tasks_managements_db.php";
require_once "../config/db_config.php";

use Models\SignIn;
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

if (
    !isset($userData['username']) || !isset($userData['password']) ||
    !isset($userData["recaptcha_response"])
) {
    respond(false, 'Invalid input');
}

// Function to verify reCAPTCHA token
require_once "../helpers/authenticate.php";
if (!verifyRecaptcha($userData['recaptcha_response'])) {
    respond(false, 'reCAPTCHA verification failed');
}


try {
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $user = new User($db, $userData["username"], $userData["password"]);
    $signIn = new SignIn($user);
    $result = $signIn->login();

    if ($result === null) {
        $_SESSION["isLoggedIn"] = true;
        $user = User::getUserByUserName($db, $userData["username"]);
        if ($user)
            respond(true, '', $user->getUserName(), $user->getUserId());
    } else {
        respond(false, $result);
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
