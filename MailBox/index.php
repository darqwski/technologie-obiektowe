<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-22
 * Time: 20:59
 */
session_start();
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();
$currentSession = new Session();
$currentUser = new Recrutant();
$currentUser->getPersonByID($currentSession->getUserID());

$mails = Announcement::getAnnouncementForPerson($currentUser);
print_r($_SESSION);
foreach ($mails as $mail){
    echo $mail->getEmployee()->getSurname().' '.$mail->getEmployee()->getName().' oglosil:</br><b>'.$mail->getText().'</b> <u>'.$mail->getDate().'</u></br>';
}