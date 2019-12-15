<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:04
 */
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();


session_start();
if(isset($_GET['logout'])){
    session_destroy();
}
print_r($_POST);

if(isset($_POST['login'])){
    if(isset($_POST['password'])){
        $person = getCommand("SELECT * FROM `persons` WHERE `Login` = '$_POST[login]' AND `Password` = '".md5($_POST['password'])."'")[0];
        print_r($person);
        if($person){
            switch ($person['userType']){
                case 'employee':
                    $employee = new Employee();
                    $employee->getPersonByID($person['ID']);
                    Session::setSession($employee);
                    header('Location: ../Dashboard/');
                    break;
                case 'recrutant':
                    $recrutant = new Recrutant();
                    $recrutant->getPersonByID($person['ID']);
                    Session::setSession($recrutant);
                    header('Location: ../Dashboard/');
                    break;
                case 'student':
                    $student = new Student();
                    $student->getPersonByID($person['ID']);
                    Session::setSession($student);
                    header('Location: ../Dashboard/');
                    break;
                case 'teacher':
                    $teacher = new Teacher();
                    $teacher->getPersonByID($person['ID']);
                    Session::setSession($teacher);
                    header('Location: ../Dashboard/');
                    break;
            }
        }
        else {

        }

    }
    else {

    }
}
else {

}
$session = new Session();

?>
????
<form action="" method="post">
   Login <input name="login" />
   Hasło <input name="password" type="password" />
    <button type="submit">Zaloguj</button>
    <a href="../Register">Zarejestruj sie</a>
</form>
