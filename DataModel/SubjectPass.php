<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-01
 * Time: 18:39
 */

include_once  $_SERVER['DOCUMENT_ROOT']."/DataModel/Subject.php";


class SubjectPass extends Subject
{
    private $mark, $status ;

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return integer
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param integer $mark
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
    }

    public function getStringStatus(){
        switch ($this->getStatus()){
            case 0:
                return 'To pass';
            case 1:
                return 'Passed';
            case -1:
                return 'Failed';
        }
    }
    public function saveToDB()
    {
        // TODO: Implement saveToDB() method.
    }

    public function readFromDB($row)
    {
        parent::readFromDB($row);
        $this->setStatus($row['Status']);
        $this->setMark($row['Mark']);
    }
}