<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.11.2018
 * Time: 21:51
 */

/*
 * Base class for all admin clases
 */
abstract class AdminBase
{
    /*
     * Make access in adminpanel for only admins
     */
    public static function checkAdmin(){
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        if ($user['role'] == 'admin'){
            return true;
        }
        die('доступ запрещен');
    }

}