<?php

namespace Helpers;

class Utility
{
    static public function cleanInput($input)
    {
        $input =  trim($input);
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    static public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
