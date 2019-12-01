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

if(isset($_POST['recrutation'])){
    $registration = new Recrutation();
    $registration->setRecrutationData(['numberOfPlaces'=>'0','studyfield'=>'1']);
    $registration->doRecrutation();
    $approvedStudents = $registration->getStudentApproved();
    foreach ($approvedStudents as $student){
        Announcement::saveAnnouncement(
                "Gratulacje! Zostałeś przyjęty na studia. Potwierdź że zapisujesz się na studia, w przeciwnym wypadku nie zostaniesz przyjęty",
                $student->getPersonID()
        );
    }
    ServerState::moveRecrutation();

}
else if(isset($_POST['start'])){
    ServerState::moveRecrutation();
}
 ?>

Witaj rekruterze!</br>
O to lista rekrutujacych sie studentow</br>

<?php
$registration = new Recrutation();
$students = $registration->getStudentInRecrutation();
foreach ($students as $student){
    echo $student->getName().' '.$student->getSurname().'<br>';
}
?>
</br>
O to lista zarekrutowanych studentow</br>

<?php
$registration = new Recrutation();
@$students = $registration->getStudentApproved();
if($students == false){
    echo "NIKOGO!";
}
else {
    foreach ($students as $student){
        echo $student->getName().' '.$student->getSurname().'<br>';
    }
}
?>


<?php
echo "Aktualny stan to:";
$arrayOfStates =   ServerState::inStates();
foreach ($arrayOfStates as $state){
    echo $state->getType().'<br>';
}
?>

<form action="" method="post">
    <?php
    if(ServerState::inRecrutation())
        echo  ' <button type="submit" name="recrutation">Zrob rekrutacje</button>';
    else
        echo  ' <button type="submit" name="start">Rozpocznij</button>';
    ?>
</form>
