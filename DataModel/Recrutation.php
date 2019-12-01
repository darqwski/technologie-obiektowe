<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 18:31
 */

include_once  $_SERVER['DOCUMENT_ROOT']."/Constants/RecrutantStatus.php";

class Recrutation
{
    private $numberOfPlaces;
    private $studyfield;

    public function setRecrutationData($postData){
        $this->numberOfPlaces = $postData['numberOfPlaces'];
        $this->studyfield = $postData['studyfield'];
    }
    public function getStudentsByStatus($status){
        $students = getCommand("SELECT * FROM `recruitants` INNER JOIN `Persons` ON `Persons`.ID = recruitants.PersonID WHERE `Status` = $status");
        return array_map(function($row){
            $student = new Student();
            $student->readPersonFromDB($row);
            return $student;
        },$students);
    }
    /*
     * @return Student[]
     */

    public function getStudentInRecrutation(){
      return $this->getStudentsByStatus(IN_RECRUTATION_PROCESS);
    }

    /*
     * @return Student[]
     */
    public function getStudentApproved(){
        return $this->getStudentsByStatus(APPROVED);
    }

    public function getStudentRegistered(){
        return $this->getStudentsByStatus(REGISTERED);
    }

    public function approveStudents($students){
        foreach ($students as $studentID){
            $id = $studentID['ID'];
            putCommand("UPDATE `dziekanat`.`recruitants` 
                  SET `Status` = '".APPROVED."' WHERE `recruitants`.`ID` =$id AND `StudyField`='".$this->studyfield."'");
        }
    }

    public function doRecrutation(){
        // TODO Add calculating number of places and approved
        $students = getCommand("SELECT recruitants.ID FROM `recruitants`
 INNER JOIN `Persons` ON `Persons`.ID = recruitants.PersonID 
 WHERE `Status` = 0 ORDER BY `point` LIMIT ".$this->numberOfPlaces);

        $this->approveStudents($students);
        // $this->sentAnnoucments()
    }
}