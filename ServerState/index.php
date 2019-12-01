<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-01
 * Time: 12:37
 */

include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();

if(isset($_POST['nextState'])){
    ServerState::moveSystemState();
}
?>

<?php
echo "Aktualny stan to:";
$arrayOfStates =   ServerState::inStates();
foreach ($arrayOfStates as $state){
   echo $state->getType().'<br>';
}
?>
</br>
<form method="post">
    <button type="submit" name="nextState">Przejdź do następnego stanu</button>
</form>
