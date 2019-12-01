<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-25
 * Time: 18:53
 */

interface DBInterface
{
    public function saveToDB();
    public function readFromDB($row);
}