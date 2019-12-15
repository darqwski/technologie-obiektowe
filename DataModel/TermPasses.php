<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-15
 * Time: 22:26
 */

include_once '../Modules/PDOController.php';

class TermPasses
{
    function getTermPassesToGive(){
        print_r(getCommand("SELECT *
            FROM students
            INNER JOIN subjectpass ON subjectpass.studentID = students.id AND subjectpass.term = students.term
            INNER JOIN persons ON persons.ID = students.PersonID"));

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