<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-01
 * Time: 18:09
 */

session_start();
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();
$currentSession = new Session();
$currentUser = new Student();
$currentUser->getPersonByID($currentSession->getUserID());

$passes = $currentUser->getSubjectPass();
echo '<table>';
foreach ($passes as $subjectPass){
   echo "
<tr>
    <td>".$subjectPass->getName()."</td>
    <td>".$subjectPass->getStringStatus()."</td>
</tr>
   ";
}
echo '</table>';

?>

