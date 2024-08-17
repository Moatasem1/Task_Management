<?php
function isUserVerified()
{
    if (isset($_SESSION["isRegister"]) && $_SESSION["isRegister"]) {
        return  true;
    } else if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] && isset($_SESSION["is2FPass"]) && $_SESSION["is2FPass"])
        return true;

    return false;
}

function verifyRecaptcha($recaptchaResponse)
{
    $recaptchaSecret = '6LeMuigqAAAAAL23cuYHagsMvTMqwJXekmJaGKaL';
    $recaptchaVerifyUrl = "https://www.google.com/recaptcha/api/siteverify";

    $response = file_get_contents("$recaptchaVerifyUrl?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    return $responseKeys["success"];
}
