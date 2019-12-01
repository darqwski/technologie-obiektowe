<?php
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PDOController.php";
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/RequestReceiver.php";

$requestReceiver = new RequestReceiver();
$requestReceiver->addRequestModule(new RequestFormat('POST','start_recrutation',Array(),'startRecrutation'));