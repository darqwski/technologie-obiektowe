<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:23
 */

class Teacher extends Person
{

    public function getUserType()
    {
        return 'teacher';
    }

    public function readFromDB($row)
    {
        // TODO: Implement readFromDB() method.
    }

    public function getPersonByID()
    {
        // TODO: Implement getPersonByID() method.
    }
}