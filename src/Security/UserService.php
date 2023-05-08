<?php

namespace App\Security;

use App\Entity\User;

class UserService
{


    public function __construct()
    {

    }

    public static function setUserSession(User $user):void
    {
        session_start();
        $_SESSION[$_ENV["SESSION_NAME_USER"]] = $user->getEmail();
    }

    public static function  setUserCookie(User $user):void
    {
        setcookie($_ENV["COOKIE_NAME_USER"], $user->getEmail(), time() + 60 * 60 * 24 * 365, '/');
    }


}