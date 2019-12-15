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
if(isset($_POST['subjectID'])){
    $currentUser->takeCourseRetake($_POST['subjectID']);
}
$passes = $currentUser->getSubjectPass();
echo '<table>';
foreach ($passes as $subjectPass){
   echo "
<tr>
    <td>".$subjectPass->getName()."</td>
    <td>".$subjectPass->getStringStatus()."</td>
    
</tr>
   ";
   if($subjectPass->getStatus() == FAILED){
      echo "
    <tr>
        <td>
        <form method='post'>
            <input type='hidden' name='subjectID' value='".$subjectPass->getId()."'/>
            <button>Weź waruneczek</button>
        </form>
</td>

    </tr>";
   }

}
echo '</table>';

?>

