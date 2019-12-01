<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:08

 * $this->setSurname($_POST['surname']);
$this->setName($_POST['name']);
$this->setPesel($_POST['pesel']);
$this->setAddress($_POST['address']);
$this->setPoints($_POST['points']);
$this->setStudyField(Studyfield::getStudyfieldByID($_POST['studyfield']));
$this->password = md5($_POST['password']);
 */

include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();

if(isset($_POST['password'])){
    $recrutant = new Recrutant();
    $recrutant->readRecrutantFromPOST();
    $recrutant->saveToDB();
    echo "Zarejestrowano pomyślnie";
}
?>
<form method="post">
    Imię : <input name="name"/>
    Nazwisko : <input name="surname"/>
    Pesel : <input name="pesel"/>
    Adres : <input name="address"/>
    Zdobyte punkty : <input name="points"/>
    Kierunek studiów : <input name="studyfield"/>
    hasło : <input name="password" type="password"/>
    <button type="submit">Zarejersturj</button>
</form>