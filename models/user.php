<?php

namespace Models;

require_once "../helpers/utility.php";
require_once "tasks_managements_db.php";

use Helpers\Utility;
use Models\TasksManagementsDB;
use PDO;

class User
{
    private TasksManagementsDB $db;
    private int|null $userId;
    private string $username;
    private string $password;

    private string $email;

    private $twoFactorSecretKey;

    //define task class later
    private $tasks = [];

    public function __construct(TasksManagementsDB $db, string $username, string $password, $userId = null, $tasks = [])
    {
        $this->db = $db;
        $this->setUserName($username);
        $this->setPassword($password);
        $this->userId = $userId;
        $this->tasks = $tasks;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    static public function getUserByUserName(TasksManagementsDB $db, string $userName)
    {
        $sql = 'SELECT id,username,password_hash from users where username = :username ';
        $stmt = $db->excuteQuery($sql, [":username" => $userName]);
        $result = $db->fetchQueryStatment($stmt);

        if (!$result) {
            return null;
        }

        $result = $result[0];

        return new User($db, $userName, $result["password_hash"], $result["id"]);
    }

    public function setUserName(string $username): void
    {
        $this->username = Utility::cleanInput($username);
    }

    public function getUserName(): string
    {
        return $this->username;
    }
    public function settwoFactorSecretKey(string $twoFactorSecretKey): void
    {
        $this->twoFactorSecretKey = Utility::cleanInput($twoFactorSecretKey);
    }

    public function gettwoFactorSecretKey(): string
    {
        return $this->twoFactorSecretKey;
    }

    public function setPassword(string $password): void
    {
        $this->password = Utility::cleanInput($password);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail(string $email): void
    {
        $this->email = Utility::cleanInput($email);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isUsernameFound(): bool
    {
        $sql = "SELECT 1 FROM users where username = :username;";

        $stmt = $this->db->excuteQuery($sql, [":username" => $this->username]);

        $result = $this->db->fetchQueryStatment($stmt);

        return !empty($result);
    }

    public function saveUser(): bool
    {
        $sql = "INSERT Into users (username,password_hash,email,two_factor_secret_key) Values (:username,:password_hash,:email,:twoFactorSecretKey);";

        $stmt = $this->db->excuteQuery($sql, [
            ":username" => $this->username,
            ":password_hash" => Utility::hashPassword($this->password),
            ":email" => $this->email,
            ":twoFactorSecretKey" => $this->twoFactorSecretKey
        ]);

        $this->userId = $this->db->getLastInsertId();

        if ($stmt->rowCount() > 0)
            return true;

        return false;
    }

    public function validateUserName(): ?string
    {
        // Username length should be between 3 and 20 characters; only letters, numbers, and underscores are allowed
        $usernameCharactersRegex = '/^[a-zA-Z0-9_]+$/';
        $usernameLengthRegex = '/^[a-zA-Z0-9_]{3,20}$/';

        if (empty($this->username)) {
            return "Username can't be empty";
        } elseif (!preg_match($usernameCharactersRegex, $this->username)) {
            return "Username consists of letters, numbers, and underscores only";
        } elseif (!preg_match($usernameLengthRegex, $this->username)) {
            return "Username length must be between 3 and 20 characters";
        } else {
            return null;
        }
    }

    public function validatePassword(): ?string
    {
        // Password length should be between 5 and 12 characters; can include letters, numbers, and special characters
        $passwordRegex = '/^[a-zA-Z0-9!@#$%^&*()_+={}\[\]|\\:;\'",.<>?\/-]{5,12}$/';

        if (empty($this->password)) {
            return "Password can't be empty";
        } elseif (!preg_match($passwordRegex, $this->password)) {
            return "Password length must be between 5 and 12 characters";
        } else {
            return null;
        }
    }

    public function authenticateUser(): bool
    {
        $sql = "SELECT password_hash FROM users WHERE username = :username;";
        $stmt = $this->db->excuteQuery($sql, [":username" => $this->username]);
        $result =  $this->db->fetchQueryStatment($stmt);

        if (empty($result)) {
            return false;
        }

        return password_verify($this->password, $result[0]['password_hash']);
    }

    static function getTwoFactorSecretKeyFromDB(TasksManagementsDB $db, int $userId)
    {
        $sql = 'SELECT two_factor_secret_key from users where id = :userId ';
        $stmt = $db->excuteQuery($sql, [":userId" => $userId]);
        $result = $db->fetchQueryStatment($stmt);

        if (!$result) {
            return null;
        }

        $result = $result[0];

        return $result["two_factor_secret_key"];
    }
}
