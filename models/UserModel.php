<?php

namespace Models;

class UserModel
{
    private static $admin = [
        'login' => 'admin',
        'password' => '123'
    ];

    public static function login($login, $password)
    {
        $ret = false;
        if ($login === static::$admin['login'] && $password === static::$admin['password']) {
            $_SESSION['isAdmin'] = true;
            $ret = true;
        }

        return $ret;
    }

    public static function isAdmin()
    {
        return boolval($_SESSION['isAdmin']);
    }

    public static function logout()
    {
        unset($_SESSION['isAdmin']);
    }

}