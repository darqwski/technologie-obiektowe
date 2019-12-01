<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-22
 * Time: 21:24
 */


session_start();
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();
$currentSession = new Session();
$currentUser = new Recrutant();
$currentUser->getPersonByID($currentSession->getUserID());

if(isset($_POST['message'])){
    Announcement::saveAnnouncement($_POST['message'],$_POST['person']);
}
?>

<form method="post">
    <input name="message" />
    <select name="person">
    <?php
        $persons = Person::getPersonsList();
        echo "<option>Do wszystkich</option>";
    foreach ($persons as $person){
            echo "<option value='$person[id]'>$person[name] $person[surname]</option>";
        }
    ?>
    </select>

    <button type="submit">send</button>
</form>
