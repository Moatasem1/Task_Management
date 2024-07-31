<?php

namespace Helpers;

class Utility
{
    static public function cleanInput($input)
    {
        $input =  trim($input);
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}
