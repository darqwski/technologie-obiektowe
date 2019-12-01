
<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:59
 */
session_start();
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();



$currentSession = new Session();
$currentUser = new Recrutant();
$currentUser->getPersonByID($currentSession->getUserID());

if(isset($_POST['papers'])){
    echo $currentUser->moveToStudents();
}
else if(isset($_POST['resign'])){
    echo $currentUser->resign();
}
?>
<meta charset="UTF-8"/>
<?php
echo 'WITAJ'.$currentUser->getName().' '.$currentUser->getSurname().'<br>';
echo 'Twoj status to : '.$currentUser->getStringStatus();
if($currentUser->getStatus() == APPROVED){
    echo '<br>'."GRATULACJE, DOSTAŁEŚ SIĘ NA KIERUNEK - ".$currentUser->getStudyField()->getName().'<br>';
    echo "<form method='post'><button name='papers'>Złóż papiery</button><button name='resign'>Zrezygnuj</button></form>";
}
?>

