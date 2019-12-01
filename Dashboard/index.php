<?php

/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 17:19
 */
session_start();
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();
$currentSession = new Session();
echo 'Witaj '.$currentSession->getLogin();

if(isset($_POST['mockStudent'])){
    for($i=0;$i<10;$i++){
        $data = [];
        $data['name'] = 'name '.rand(0,100);
        $data['surname'] = 'random'.rand(0,100);
        $data['pesel'] = 'random pesel';
        $data['address'] = 'random address';
        $data['studyfield'] = '1';
        $data['points'] = rand(80,160);
        $data['password'] = 'root';
        $recrutant = new Recrutant();
        $recrutant->readRecrutantFromData($data);
        $recrutant->saveToDB();
    }
}
 ?>
<meta charset="UTF-8"/>
<br />
<a href="../MailBox"> Skrzynka ogłoszeń</a>;

<?php
if($currentSession->getUserType() == 'employee'){
    echo '<a href="../Recrutation/Recruiter"> Panel rektutacji</a>';
}
if($currentSession->getUserType() == 'employee'){
    echo '<a href="../ServerState"> Panel zarządzania okresami studiów</a>';
}
else if($currentSession->getUserType() == 'recruitant'){
    echo '<a href="../Recrutation/Recrutant"> Panel rektutacji</a>';
}

if($currentSession->getUserType() == 'employee'){
    echo "
        <form method='post'>
            <button type='submit' name='mockStudent'> Wygeneruj 10 studentow</button>
        </form>
    ";
}
?>


