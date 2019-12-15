<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-25
 * Time: 20:19
 */

define("RECRUTATION1","RECRUTATION1");
define("RECRUTATION2","RECRUTATION2");
define("RECRUTATION3","RECRUTATION3");
define("NORECRUTATION","NORECRUTATION");
define("WINTERPREPARATION","WINTERPREPARATION");
define("WINTERTERM","WINTERTERM");
define("WINTERSESSION1","WINTERSESSION1");
define("WINTERSESSION2","WINTERSESSION2");
define("WINTERSESSION3","WINTERSESSION3");
define("SUMMERPREPARATION","SUMMERPREPARATION");
define("SUMMERTERM","SUMMERTERM");
define("SUMMERSESSION1","SUMMERSESSION1");
define("SUMMERSESSION2","SUMMERSESSION2");
define("SUMMERSESSION3","SUMMERSESSION3");
define("PAUSE","PAUSE");
class ServerState
{

    private $name = "";
    private $startDate = null;
    private $endDate = null;
    private $type = null;

    private static function doWinterPreparation()
    {
      $studentsData = getCommand( "SELECT * FROM `students`WHERE `Term` =0");
      $students = [];
      foreach ($studentsData as $studentsDatum){
          $student = new Student();
          $student->readFromDB($studentsDatum);
          $student->generateStudentPasses();
          $student->moveToNextTerm();
      }

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param null $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param null $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    private static function inState($state){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL AND `Type`='$state'";
        return getCommand($sqlQuery) !== false;
    }

    /**
     * @return ServerState
     */
    public static function getFromDB($row){
        $serverState = new ServerState();
        $serverState->setName($row['Name']);
        $serverState->setType($row['Type']);
        $serverState->setEndDate($row['StartDate']);
        $serverState->setStartDate($row['EndDate']);

        return $serverState;
    }
    /**
     * @return ServerState[]
     */
    public static function inStates(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL";
        return array_map(function ($item){
            return self::getFromDB($item);
        },getCommand($sqlQuery));
    }

    /**
     * @return bool
     */
    public static function inRecrutation(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL AND (`Type`='RECRUTATION1' OR `Type`='RECRUTATION2' OR `Type`='RECRUTATION3')";
        return getCommand($sqlQuery) !== false;
    }
    public static function inRecrutation1(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL AND (`Type`='RECRUTATION1' )";
        return getCommand($sqlQuery) !== false;
    }
    public static function inRecrutation2(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL AND ( `Type`='RECRUTATION2' )";
        return getCommand($sqlQuery) !== false;
    }
    public static function inRecrutation3(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL AND (`Type`='RECRUTATION3' )";
        return getCommand($sqlQuery) !== false;
    }

    private static function startState($state){
        $createQuery="INSERT INTO `dziekanat`.`serverstate` (`ID` ,`Name` ,`StartDate` ,`EndDate` ,`Type`)
                        VALUES (NULL , '$state', NOW(), NULL , '$state');";
        getCommand($createQuery);
        return true;
    }
    private static function endState($state){
        $createQuery="UPDATE `dziekanat`.`serverstate` SET `EndDate` = 'NOW()' WHERE `serverstate`.`Type` ='$state' AND EndDate IS NULL ";
        $number = putCommand($createQuery);
        return $number == 1;
    }

        public static function moveRecrutation(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL 
AND (`Type`='NORECRUTATION' OR`Type`='RECRUTATION1' OR `Type`='RECRUTATION2' OR `Type`='RECRUTATION3')";
        $state = getCommand($sqlQuery)[0];
        putCommand("UPDATE `dziekanat`.`serverstate` SET `EndDate` = 'NOW()' WHERE `serverstate`.`ID` ='$state[ID]'");
        $createQuery="";
        switch ( $state['Type']){
            case NORECRUTATION:
                if(ServerState::inState(SUMMERSESSION2)){
                    $createQuery="INSERT INTO `dziekanat`.`serverstate` (`ID` ,`Name` ,`StartDate` ,`EndDate` ,`Type`)
                            VALUES (NULL , '".RECRUTATION1."', NOW(), NULL , '".RECRUTATION1."');";
                }
                else {
                    return "Rekrutacje można rozpocząć dopiero w sesji poprawkowej";
                }
                break;
            case RECRUTATION1:
                $createQuery="INSERT INTO `dziekanat`.`serverstate` (`ID` ,`Name` ,`StartDate` ,`EndDate` ,`Type`)
                        VALUES (NULL , '".RECRUTATION2."', NOW(), NULL , '".RECRUTATION2."');";
                break;
            case RECRUTATION2:
                $createQuery="INSERT INTO `dziekanat`.`serverstate` (`ID` ,`Name` ,`StartDate` ,`EndDate` ,`Type`)
                        VALUES (NULL , '".RECRUTATION3."', NOW(), NULL , '".RECRUTATION3."');";
                break;
            case RECRUTATION3:
                $createQuery="INSERT INTO `dziekanat`.`serverstate` (`ID` ,`Name` ,`StartDate` ,`EndDate` ,`Type`)
                        VALUES (NULL , '".NORECRUTATION."', NOW(), NULL , '".NORECRUTATION."');";
                break;
        }
        insertCommand($createQuery);
    }

    public static function moveSystemState(){
        $sqlQuery = "SELECT * FROM `serverstate` WHERE EndDate IS NULL   
  AND (`Type`!='NORECRUTATION' AND`Type`!='RECRUTATION1' AND `Type`!='RECRUTATION2' AND `Type`!='RECRUTATION3')";
        $states = getCommand($sqlQuery);
        $currentState = ServerState::getFromDB($states[0]);
        if(count($states)==2){
            self::endState(SUMMERSESSION3);
            self::endState(WINTERSESSION3);
            return "Letnia Sesja poprawkowa została zakończona";
        }
        if(ServerState::inRecrutation())
            return;
        self::endState($currentState->getType());
        switch ($currentState->getType()){
            case SUMMERSESSION2:
                self::startState(WINTERPREPARATION);
                self::doWinterPreparation();

                break;
            case WINTERPREPARATION:
                self::startState(WINTERTERM);
                self::startState(SUMMERSESSION3);
                break;
            case WINTERTERM:
                self::startState(WINTERSESSION1);
                break;
            case WINTERSESSION1:
                self::startState(WINTERSESSION2);
                break;
            case WINTERSESSION2:
                self::startState(SUMMERPREPARATION);
                break;
            case SUMMERPREPARATION:
                self::startState(WINTERSESSION3);
                self::startState(SUMMERTERM);
                break;
            case SUMMERTERM:
                self::startState(SUMMERSESSION1);
                break;
            case SUMMERSESSION1:
                self::startState(SUMMERSESSION2);
                break;
        }
    }

    public static function getTerm(){
       $winterTerm = self::inState(WINTERTERM) || self::inState(WINTERSESSION1) ||  self::inState(WINTERSESSION2);
       $summerTerm = self::inState(SUMMERTERM) || self::inState(SUMMERSESSION1) ||  self::inState(SUMMERSESSION2);
        if($winterTerm)
            return WINTERTERM;
        if($summerTerm)
            return SUMMERTERM;
        return PAUSE;
    }

}