<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:21
 */

class Employee extends Person implements JsonSerializable
{
    private $canRecruit;
    private $canMoney;
    private $canReserve;
    private $isAdmin;

    /**
     * @return mixed
     */
    public function getCanRecruit()
    {
        return $this->canRecruit;
    }

    /**
     * @param mixed $canRecruit
     */
    public function setCanRecruit($canRecruit)
    {
        $this->canRecruit = $canRecruit;
    }

    /**
     * @return mixed
     */
    public function getCanMoney()
    {
        return $this->canMoney;
    }

    /**
     * @param mixed $canMoney
     */
    public function setCanMoney($canMoney)
    {
        $this->canMoney = $canMoney;
    }

    /**
     * @return mixed
     */
    public function getCanReserve()
    {
        return $this->canReserve;
    }

    /**
     * @param mixed $canReserver
     */
    public function setCanReserve($canReserve)
    {
        $this->canReserve = $canReserve;
    }

    /**
     * @return mixed
     */
    public function getisAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function readFromDB($row)
    {
        $this->readPersonFromDB($row);
        $this->setCanMoney($row['canMoney'] == 1);
        $this->setCanRecruit($row['canRecruit'] == 1);
        $this->setCanReserve($row['canReserve'] == 1);
        $this->setIsAdmin($row['isAdmin'] == 1);

    }

    public function getUserType()
    {
        return 'employee';
    }

    public function getTableName()
    {
        return 'employees';
    }
}