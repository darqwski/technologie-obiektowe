<?php
include_once  $_SERVER['DOCUMENT_ROOT']."/Modules/PageGenerator.php";
includeAll();

if(isset($_POST['nextState'])){
    ServerState::moveSystemState();
}
?>

<?php
echo "Aktualny stan to:";
if(ServerState::inPreparation()){
    echo "Wez do zaliczenia do przyznania";
    $termPasses = new TermPasses();
    echo '<pre>';
    $termPasses->getTermPassesToGive();
}
?>
