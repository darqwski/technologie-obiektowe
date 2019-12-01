<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-21
 * Time: 19:35
 */

include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();

function startRecrutation(){
    $recrutation = new Recrutation();
    $recrutation->setRecrutationData($_POST);
    $recrutation->doRecrutation();
}