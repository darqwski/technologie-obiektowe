<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-22
 * Time: 21:58
 */

interface PersonInterface
{
    public function getUserType();
    public function readFromDB($row);

    public function getTableName();
}