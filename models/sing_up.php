<?php

namespace Models;

require_once "../helpers/utility.php";
require_once "../models/user.php";

use Helpers\Utility;

class SingUp
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(): ?string
    {

        $result = $this->user->validateUserName();

        if ($result !== null) return $result;

        //validate Email here

        $result = $this->user->validatePassword();
        if ($result !== null) return $result;

        $result = $this->user->isUsernameFound();

        if ($result) return "username is already taken. Please choose another one";
        if (!$this->user->saveUser())
            return "something go wrong";

        return null;
    }
}
