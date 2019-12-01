<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 19:24
 */

include_once  $_SERVER['DOCUMENT_ROOT']."/Constants/RecrutantStatus.php";
include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/DBInterface.php";
include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Studyfield.php";

class Recrutant extends Person implements DBInterface
{

    private $status = 0;
    private $points = 0;
    private $studyField = null;
    private $password = null;
    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return int
     */
    public function getStudyField()
    {
        return $this->studyField;
    }

    /**
     * @param int $studyField
     */
    public function setStudyField($studyField)
    {
        $this->studyField = $studyField;
    }
    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getUserType()
    {
        return 'recruitant';
    }

    public function readFromDB($row)
    {
        $this->readPersonFromDB($row);
        $this->setStatus($row['Status']);
        $this->setStudyField(Studyfield::getStudyfieldByID($row['StudyField']));
        $this->setPoints($row['Point']);
    }
    public function readRecrutantFromData($data){
        $this->setSurname($data['surname']);
        $this->setName($data['name']);
        $this->setPesel($data['pesel']);
        $this->setAddress($data['address']);
        $this->setPoints($data['points']);
        $this->setStudyField(Studyfield::getStudyfieldByID($data['studyfield']));
        $this->password = md5($data['password']);
    }

    public function readRecrutantFromPOST(){
        $this::readRecrutantFromData($_POST);
    }

    public function getStringStatus(){
        switch ($this->getStatus()){
            case APPROVED:
                return "Approved";
            case IN_RECRUTATION_PROCESS:
                return "IN RECRUTATION PROCESS";
            case REGISTERED:
                return "REGISTERD";
            case RESIGNED:
                return "RESIGNED";
        }
    }

    public function getTableName()
    {
        return 'recruitants';
    }

    private function generateLogin(){
        return $this->getSurname();
    }

    public function moveToStudents(){
        $personID = $this->getPersonID();
        return Student::createStudent($personID,$this->getId());
    }
    public function saveToDB()
    {
        $id = insertCommand("INSERT INTO `dziekanat`.`persons` (
            `ID` ,`Login` ,`Password` ,`userType` ,`Name` ,`Surname` ,`Address` ,`PESEL`
            )VALUES (
            NULL , 
            '".$this->generateLogin()."', 
            '".md5($this->password)."', 
            'recrutant',
             '".$this->getName()."', 
            '".$this->getSurname()."',
             '".$this->getAddress()."', 
             '".$this->getPesel()."'
            )");
        $recrutantId = insertCommand("
          INSERT INTO `dziekanat`.`recruitants` (
            `ID` , `PersonID` , `Point` , `StudyField` , `Status`
            ) VALUES (
            NULL , '$id', '".$this->getPoints()."', '".$this->getStudyField()->getId()."', '0'
            );");
        return $recrutantId;
    }

    public function resign()
    {
        putCommand("UPDATE `recruitants` SET `Status` = '-1' WHERE `recruitants`.`ID` =".$this->getId());
    }
}