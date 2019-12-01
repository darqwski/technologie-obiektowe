<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:09
 */

class Session
{
    public function __construct()
    {
    }

    public function getLogin(){
        return $_SESSION['login'];
    }

    public function getUserType(){
        return $_SESSION['userType'];
    }

    public function getUserID(){
        return $_SESSION['userId'];
    }

    public function getID(){
        return $_SESSION['typeId'];
    }

    public static function setSession(Person $user){
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['userId'] = $user->getPersonID();
        $_SESSION['userType'] = $user->getUserType();
        $_SESSION['typeId'] = $user->getID();
    }

    public function isLogged(){
        return isset($_SESSION['username']);
    }
}