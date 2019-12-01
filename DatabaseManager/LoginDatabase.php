<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-01
 * Time: 18:18
 */

function checkLogin($login,$password){
    $person = getCommand("SELECT * FROM `persons` WHERE `Login` = $login' AND `Password` = '".md5($password)."'")[0];

    return $person;
}