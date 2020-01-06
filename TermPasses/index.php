<?php
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();
session_start();
if(isset($_POST['nextState'])){
    ServerState::moveSystemState();
}
if(isset($_POST['studentID'])){
    $termPasses = new TermPasses();
    $currentSession = new Session();
    $termPasses->giveTermPassToStudent($_POST['studentID'], $currentSession->getUserID());
}
?>

<?php
echo "Aktualny stan to:";
if(ServerState::inPreparation()){
    echo "Wez do zaliczenia do przyznania";
    $termPasses = new TermPasses();
    echo '<pre>';
    $passes = ($termPasses->getTermPassesToGive());

    $studentPasses = [];
    foreach ($passes as $termPass){
        $index = $termPass['studentID'];

        if(!isset($studentPasses[$index])){
            $studentPasses[$index] = [];
        }
        array_push($studentPasses[$index],$termPass);
    }

    foreach ($studentPasses as $studentPass){

        echo "
            <form method='post'>
                <input type='hidden' value='".$studentPass[0]['studentID']."' name='studentID'/>
                <p>".$studentPass[0]['studentName']." ".$studentPass[0]['studentSurname']."</p>";
                $canGiveTermPass = true;
            foreach ($studentPass as $pass){
                echo "<div>";
                echo "<p>$pass[subjectName]</p>";
                if($pass['status']<=0){
                    $canGiveTermPass=false;
                    echo "<p>Niezaliczone</p>";
                }else {
                    echo "<p>Zaliczone</p>";
                }
                echo "</div>";
            }
            if($canGiveTermPass){
                echo " <button type='submit'> Przyznaj zaliczenie semestru</button>";
            }
            else {
                echo "<p>Nie można przyznać zaliczenia, bo są niezdane przedmioty</p>";
            }
            echo "
            </form>
        ";
    }
}
?>
