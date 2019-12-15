<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:00
 */

include_once "PersonInterface.php";

define("USER_TYPE_RECRUTANT","recrutant");
define("USER_TYPE_EMPLOYEE","employee");
define("USER_TYPE_TEACHER","teacher");

class Person implements JsonSerializable, PersonInterface
{

    public function jsonSerialize()
    {
        return [
            'name'=>$this->getName(),
            'surname'=>$this->getSurname()
        ];
    }

    private $name;
    private $surname;
    private $pesel;
    private $address;
    private $personID = null;
    private $login;
    private $id;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * @param mixed $pesel
     */
    public function setPesel($pesel)
    {
        $this->pesel = $pesel;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    public function readPersonFromDB($row){
        $this->setSurname($row['Surname']);
        $this->setName($row['Name']);
       // $this->setPesel($row['PESEL']);
     //   $this->setAddress($row['Address']);
        $this->setPersonID($row['PersonID']);
        $this->setLogin($row['Login']);
        @$this->setId($row['ID']);
    }

    public function getPersonFromDB($row){

    }

    /**
     * @return mixed
     */
    public function getPersonID()
    {
        return $this->personID;
    }

    /**
     * @param mixed $personID
     */
    public function setPersonID($personID)
    {
        $this->personID = $personID;
    }
    public static function getPersonsList(){
        return getCommand("SELECT id, name, surname, userType FROM persons");
    }
    public function getPersonByID($id)
    {
        $data = getCommand("
      SELECT ".$this->getTableName().".*, persons.Name, persons.Surname,persons.userType,persons.Login,persons.ID as PersonID 
      FROM ".$this->getTableName()."
      INNER JOIN persons ON persons.id = ".$this->getTableName().".PersonID
      WHERE PersonID = '$id'");

        return $this->readFromDB($data[0]);
    }

    public static function getConstructorByUserType($name){
        switch ($name){
            case 'employee':
            return 'Employee';
            case 'teacher':
                return 'Teacher';
            case 'recrutant':
                return 'Recrutant';
            case 'student':
                return 'Student';
        }
        return null;
    }

    public function getUserType()
    {
        return 'person';
    }

    public function readFromDB($row)
    {
        // TODO: Implement readFromDB() method.
    }

    public function getTableName()
    {
        // TODO: Implement getTableName() method.
    }
}