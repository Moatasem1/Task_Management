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

function respond($success, $qrImgUrl)
{
    $response = [
        'success' => $success,
        'qrImgUrl' => $qrImgUrl
    ];
    echo json_encode($response);
    exit();
}

$user_id = isset($_GET['userId']) ? $_GET['userId'] : null;

if (!isset($user_id) || $user_id == null) {
    respond(false, 0, 'Invalid input');
}

require_once __DIR__ . '/../vendor/autoload.php';

use PHPGangsta\GoogleAuthenticator;

try {
    $ga = new PHPGangsta_GoogleAuthenticator();
    $db = new TasksManagementsDB($host, $dbname, $username, $password);
    $twoFactorSecretKey = User::getTwoFactorSecretKeyFromDB($db, $user_id);

    if ($twoFactorSecretKey) {
        $qrImgUrl = $ga->getQRCodeGoogleUrl('todolistApp', $twoFactorSecretKey);
        respond(true, $qrImgUrl);
    } else {
        respond(false, null);
    }
} catch (Exception $e) {
    respond(false, "An error Ocuured: " . $e->getMessage());
}
