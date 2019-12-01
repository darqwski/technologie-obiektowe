<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2019-12-01
 * Time: 18:40
 */

class Subject implements DBInterface
{
 private $name, $computers, $laboratories, $lectures, $exercises;

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Integer
     */
    public function getComputers()
    {
        return $this->computers;
    }

    /**
     * @param Integer $computers
     */
    public function setComputers($computers)
    {
        $this->computers = $computers;
    }

    /**
     * @return Integer
     */
    public function getLaboratories()
    {
        return $this->laboratories;
    }

    /**
     * @param Integer $laboratories
     */
    public function setLaboratories($laboratories)
    {
        $this->laboratories = $laboratories;
    }

    /**
     * @return Integer
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param Integer $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @return Integer
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * @param Integer $exercises
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
    }


    public function saveToDB()
    {
        // TODO: Implement saveToDB() method.
    }

    public function readFromDB($row)
    {
        $this->setName($row['Name']);
        $this->setComputers($row['Computers']);
        $this->setExercises($row['Exercises']);
        $this->setLaboratories($row['Laboratories']);
        $this->setLectures($row['Lectures']);
    }


}