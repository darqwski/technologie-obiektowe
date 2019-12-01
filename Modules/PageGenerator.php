<?php

function includeAll(){
    include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PDOController.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Person.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Student.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Employee.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Session.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Recrutation.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Recrutant.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Announcement.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/PersonInterface.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Recrutant.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/ServerState.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/SubjectPass.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Subject.php";
    include_once  $_SERVER['DOCUMENT_ROOT']."/DatabaseManager/LoginDatabase.php";
}

function importJSfiles($rootDirectory)
{
    generateSessionData();
    importAllFilesInDirectory($rootDirectory);
    importAllFilesInDirectory('common-components');
    echo "<script src='./Scripts/$rootDirectory/main.js'></script>";

}

function generateSessionData()
{
    $admins = getCommand("SELECT * FROM `ga_admins`");
    $isAdmin = false;
    foreach ($admins as $admin){
        if($admin['ID'] == $_SESSION['userId'])
            $isAdmin=true;
    }
     echo "
        <script type=\"text/javascript\">
            const serverDateTemporary = {
                session_id : '" . session_id() . "',
                fullname : '$_SESSION[fullname]',
                groupPerms :'$_SESSION[groups]',
                permissions :" . json_encode($_SESSION['permissions']) . ",
                username :'$_SESSION[username]',
                userId :'$_SESSION[userId]',
                isAdmin: $isAdmin
            }
           
        </script>";
}

function importAllFilesInDirectory($rootDirectory)
{
    foreach (glob("./Scripts/$rootDirectory/*.js") as $fileName) {
        if ($fileName !== "./Scripts/$rootDirectory/main.js")
            echo "<script src=\"$fileName\"></script>";
    }
}