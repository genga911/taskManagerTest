<?php

namespace Controllers;


class UserController
{
    /**
     * @param $vars
     * @throws \Exception
     */
    public static function login($vars)
    {
        $res = \Models\UserModel::login($vars->request['login'], $vars->request['password']);

        if ($res) {
            echo true;
        } else {
            throw new \Exception(401);
        }
    }

    public static function logout($vars)
    {
        \Models\UserModel::logout();
    }
}