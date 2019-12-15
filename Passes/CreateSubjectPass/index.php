<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-01
 * Time: 21:54
 */
session_start();
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();
$currentSession = new Session();
echo 'Witaj '.$currentSession->getLogin();
$currentUser = new Teacher();
$currentUser->getPersonByID($currentSession->getUserID());

echo "AKTUALNY SEMESTR ".ServerState::getTerm();
echo "</br> ZALICZENIA DO PRZYZNANIA";

if(isset($_POST['mark'])){
    if($_POST['mark']>=3)
        putCommand("UPDATE `dziekanat`.`subjectpass` SET `Mark` = '$_POST[mark]',`Status` = '1' WHERE `subjectpass`.`ID` =$_POST[subjectPassId]");
    else
        putCommand("UPDATE `dziekanat`.`subjectpass` SET `Mark` = '$_POST[mark]',`Status` = '-1' WHERE `subjectpass`.`ID` =$_POST[subjectPassId]");
}
/*

SELECT subjects.name, persons.Name AS sName, persons.Surname as sSurname, subjectpass.status FROM subjectpass
INNER JOIN subjects ON subjects.ID = subjectpass.SubjectID
INNER JOIN students ON students.ID = subjectpass.StudentID
INNER JOIN persons ON persons.ID = students.PersonID

 */


$passesToGive = $currentUser->getPassesToGive();

foreach ($passesToGive as $item){
echo "<form method='post'>
$item[name] $item[surname] - $item[subjectName]
<input name='mark' type='number'/>
<input type='hidden' name='subjectPassId' value='$item[SubjectPassId]'/>
<button type='submit'>Przyznaj</button>
</form>";
}

?>

