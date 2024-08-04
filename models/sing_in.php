<?php

namespace Models;

require_once "../helpers/utility.php";
require_once "../models/user.php";

use Helpers\Utility;

class SignIn
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(): ?string
    {

        $result = $this->user->validateUserName();

        if ($result !== null) return $result;

        $result = $this->user->validatePassword();
        if ($result !== null) return $result;

        $result = $this->user->authenticateUser();

        if (!$result) return "Invalid username or password";

        return null;
    }
}
