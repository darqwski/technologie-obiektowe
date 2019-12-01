<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:22
 */

class Student extends Person
{
    private $isStudent;
    private $studyField;

    /**
     * @return bool
     */
    public function getisStudent()
    {
        return $this->isStudent;
    }

    /**
     * @param bool $isStudent
     */
    public function setIsStudent($isStudent)
    {
        $this->isStudent = $isStudent;
    }

    /**
     * @return Studyfield
     */
    public function getStudyField()
    {
        return $this->studyField;
    }

    /**
     * @param Studyfield $studyField
     */
    public function setStudyField($studyField)
    {
        $this->studyField = $studyField;
    }

    public function getUserType()
    {
        return 'student';
    }

    public function readFromDB($row)
    {
        $this->readPersonFromDB($row);
        $this->setIsStudent($row['isStudent'] == 1);
        $this->setStudyField(Studyfield::getStudyfieldByID($row['Studyfield']));
    }

    public function getTableName()
    {
        return 'students';
    }

    public static function createStudent($personID, $recruitantID){
        insertCommand("INSERT INTO `dziekanat`.`students` (`ID`, `PersonID`, `isStudent`, `Studyfield`) VALUES (NULL, '$personID', '0', '1')");
        putCommand("UPDATE `dziekanat`.`persons` SET `userType` = 'student' WHERE `persons`.`ID` =$personID;");
        deleteCommand("DELETE FROM `recruitants` WHERE `ID` = $recruitantID ");
        return "Student created succesfully";
    }

    public function generateStudentPasses(){
       $studyFieldId = $this->getStudyField()->getId();
       $subjectsID = getCommand("
SELECT `subjects`.`id` from `studyfield_subjects` 
INNER JOIN `subjects` ON `studyfield_subjects`.`SubjectID` = `subjects`.`ID` 
WHERE `studyfield_subjects`.`StudyfieldID` = $studyFieldId");
       $studentID = $this->getId();
        foreach ($subjectsID as $subjectID) {
            $subjectID=$subjectID['id'];
            insertCommand("INSERT INTO `dziekanat`.`subjectpass` 
                (`ID`, `StudentID`, `SubjectID`, `Mark`, `TeacherID`, `Status`) 
                VALUES (NULL, '$studentID', '$subjectID', '0', '', '0');");
       }
    }

    /**
     * @return SubjectPass[]
     */
    public function getSubjectPass(){
       $studentPassesRaw =  getCommand(
           "SELECT `Name`,`Mark`,`Status`,`Computers`,`Lectures`,`Exercises`,`Laboratories` FROM `subjectpass`
                      INNER JOIN `subjects` ON `subjects`.`ID` = `subjectpass`.`SubjectID`
                      WHERE `StudentID` = 3 ");
       $studentPasses = [];
       foreach ($studentPassesRaw as $item){
           $studentPass = new SubjectPass();
           $studentPass->readFromDB($item);
           array_push($studentPasses, $studentPass);
       }

       return $studentPasses;
    }

    public function moveToNextTerm()
    {
        putCommand("UPDATE `dziekanat`.`students` SET `Term` = '1' WHERE `students`.`ID` =".$this->getId());
    }

}