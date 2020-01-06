<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-15
 * Time: 22:26
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/Modules/PDOController.php';

class TermPasses
{
    function getTermPassesToGive(){
        return (getCommand("
            SELECT subjects.name AS subjectName,
            persons.Name AS studentName,
            persons.Surname AS studentSurname,
            students.ID AS studentID,
            subjectpass.Status AS status
            FROM students
            INNER JOIN subjectpass ON subjectpass.studentID = students.id AND subjectpass.term = students.term
            INNER JOIN subjects ON subjects.id = subjectpass.SubjectID 
            INNER JOIN persons ON persons.ID = students.PersonID"));
    }
    function giveTermPassToStudent($studentID,$employeeID){
        insertCommand("
            INSERT INTO `dziekanat`.`termpass` (`ID`, `ECTS`, `Passed`, `StudentID`, `EmployeeID`,`Date`) 
            VALUES ('', '0', '1', '$studentID', '$employeeID',NOW());
          ");
        putCommand("UPDATE `dziekanat`.`students` SET `Term` = `Term`+1 WHERE `students`.`ID` =$studentID;");
    }
    function getPassesPerTerm(){
        return getCommand("
            SELECT count(*) AS subjectsPerTerm,`Term`, StudyFieldID  FROM `studyfield_subjects` 
            GROUP BY `Term`, StudyFieldID");
    }

    function hasEnoughPasses($student){
       $passesPerTerm =  $this->getPassesPerTerm();
    }
}