<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-11-25
 * Time: 18:41
 */

class Studyfield
{
    private $name;
    private $id;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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

    public static function getStudyfieldByID($id){
        $data = getCommand("SELECT `name`,`id` FROM `studyfields` where `ID` = '$id'");
        $newStudyField = new Studyfield();
        $newStudyField->setName($data[0]['name']);
        $newStudyField->setId($data[0]['id']);
        return $newStudyField;
    }

}