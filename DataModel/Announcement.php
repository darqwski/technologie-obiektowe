<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-22
 * Time: 20:45
 */

class Announcement implements JsonSerializable
{
    /**
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getImportance()
    {
        return $this->importance;
    }

    /**
     * @param mixed $importance
     */
    public function setImportance($importance)
    {
        $this->importance = $importance;
    }


    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    private $employee;
    private $id;
    private $person;
    private $text;
    private $date;
    private $importance;
    private $status;

    public static function getAnnouncementFromData($data){
        $announcement = new Announcement();
        $announcement->setDate($data['Date']);
        $announcement->setImportance($data['Importance']);
        $announcement->setStatus($data['Status']);
        $announcement->setText($data['Text']);
        $announcement->setId($data['ID']);
        $employee = new Employee();
        $employee->readPersonFromDB($data);
        $announcement->setEmployee($employee);
        return $announcement;
    }

    public function saveToDatabase(){
        $query = "
    INSERT INTO `dziekanat`.`announcements` 
    (`ID` ,`Text` ,`Date` ,`Importance` ,`EmployeeID` ,`PersonID` ,`Status`)
    VALUES (
      NULL ,'$this->text' , NOW(), 0, ".$this->getEmployee()->getId().", ".$this->getPerson()->getPersonID().", 0
    )";
        echo $query;
        putCommand($query);
    }

    /**
     * @param Person $user
     * @return Announcement[]
     */
    public static function getAnnouncementForPerson($user){
        $id = $user->getPersonID();
        $data = getCommand("
        SELECT * FROM `announcements`
INNER JOIN `employees` ON `employees`.`ID` = `announcements`.`EmployeeID`
INNER JOIN `persons` ON `persons`.`ID` = `employees`.`PersonID`
WHERE `announcements`.`PersonID` = '$id' 
        ");
        return array_map(function ($announcement){return self::getAnnouncementFromData($announcement);},$data);
    }

    public static function saveAnnouncement($text,$personId){
        $session = new Session();
        $employee = new Employee();
        print_r($_SESSION);
        $employee->setId($session->getID());
        $person = new Person();
        $person->setPersonID($personId);
        $announcement = new Announcement();
        $announcement->setEmployee($employee);
        $announcement->setPerson($person);
        $announcement->setText($text);
        $announcement->saveToDatabase();
    }


    public function jsonSerialize()
    {
       return  [
           'text' => $this->getText(),
           'date' => $this->getDate(),
           'status' => $this->getStatus(),
           'employee' => $this->getEmployee(),
       ];
    }

}