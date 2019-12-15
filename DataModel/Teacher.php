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
        $this->readPersonFromDB($row);
    }

    public function getTableName(){
        return 'teachers';
    }

    public function getPassesToGive(){

       return getCommand("
       SELECT subjects.name AS `subjectName`, leadings.teacherid, persons.name, 
       persons.surname, students.id as `StudentId`,subjectpass.id as `SubjectPassId`
FROM subjectpass
INNER JOIN subjects ON subjects.id = subjectpass.subjectid
INNER JOIN leadings ON leadings.subjectid= subjects.id
INNER JOIN students ON subjectpass.studentid = students.id
INNER JOIN persons ON students.personid = persons.id
INNER JOIN studyfield_subjects ON studyfield_subjects.subjectid = subjectpass.subjectid
WHERE Status = 0 
AND leadings.teacherid = ".$this->getId()." 
AND subjectpass.term = students.term
AND leadings.type = 'LEC'
");
    }
}