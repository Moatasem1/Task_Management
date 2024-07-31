<?php

namespace Models;

use Helpers\Utility;

class SingUp
{
    private $username;
    private $password;

    /**
     * validation
     * is username found
     * is password correct
     * register
     */

    public function __construct($username, $password)
    {
        $this->username = Utility::cleanInput($username);
        $this->password = Utility::cleanInput($password);
    }

    public function setUserName($username)
    {
        $this->username = Utility::cleanInput($username);
    }

    public function getUserName()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = Utility::cleanInput($password);
    }

    public function getPassword()
    {
        return $this->password;
    }
}
