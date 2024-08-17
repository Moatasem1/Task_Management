<?php
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once "../models/tasks_managements_db.php";
require_once "../models/user.php";
require_once "../config/db_config.php";

use Models\TasksManagementsDB;
use Models\User;

function respond($success, $message)
{
    $response = [
        'success' => $success,
        'message' => $message
    ];
    echo json_encode($response);
    exit();
}

$twoFactorSecretCode = isset($_GET['twoFactorSecretCode']) ? $_GET['twoFactorSecretCode'] : null;
$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

if ($userId == null || $twoFactorSecretCode == null) {
    respond(false, 'Invalid input');
}

require_once __DIR__ . '/../vendor/autoload.php';

use PHPGangsta\GoogleAuthenticator;

try {
    $ga = new PHPGangsta_GoogleAuthenticator();
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $twoFactorSecretKey = User::getTwoFactorSecretKeyFromDB($db, $userId);
    if (!$twoFactorSecretCode) {
        respond(false, "secrete code not found");
        exit();
    }

    $checkResult = $ga->verifyCode($twoFactorSecretKey, $twoFactorSecretCode, 1);
    if ($checkResult) {
        $_SESSION["is2FPass"] = true;
        respond(true, "successfull");
    } else {
        respond(false, "not verified");
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
