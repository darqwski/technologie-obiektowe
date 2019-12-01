<?php
    include_once "DatabaseShortFunctions.php";
    /*
     * @param $command -> SQL COMMAND
     * Function bassicly for getting data from database
     * For :	SELECT FROM
     */
    function getCommand($command){
        $PDO_login='usbw';
        $PDO_passwd='root';
        $PDO_text='mysql:host=localhost;dbname=dziekanat;charset=utf8;encoding=utf8;port=3307';
        try {$db = new PDO($PDO_text, $PDO_passwd, $PDO_login);}
        catch (PDOException $e) {print "Failed to connect database!: " . $e->getMessage() . "<br/>";}
        try{
            $records = $db->query($command);
            if($records == false)
                return false;
            $return=$records->fetchAll(PDO::FETCH_ASSOC);
            if($return == false)
                return false;
            return $return;
        } catch (PDOException $e){
            return "DATABASE ERROR";
        }
    }
    /*
     * @param $command -> SQL COMMAND
     * Function bassicly for insert command which return only number of new,change records
     * For : INSERT INTO, UPDATE, DELETE FROM and TABLE modulators
     */
    function putCommand($command){
     $PDO_login='usbw';
        $PDO_passwd='root';
        $PDO_text='mysql:host=localhost;dbname=dziekanat;charset=utf8;encoding=utf8;port=3307';
            try {$db = new PDO($PDO_text, $PDO_passwd, $PDO_login);}
        catch (PDOException $e) {return "Failed to connect database!: " . $e->getMessage() . "<br/>";}
        $return = $db->exec($command);
        return $return;
    }

    function insertCommand($command){
        $PDO_login='usbw';
        $PDO_passwd='root';
        $PDO_text='mysql:host=localhost;dbname=dziekanat;charset=utf8;encoding=utf8;port=3307';
        try {$db = new PDO($PDO_text, $PDO_passwd, $PDO_login);}
        catch (PDOException $e) {return "Failed to connect database!: " . $e->getMessage() . "<br/>";}
        $db->exec($command);
        $records = $db->query("SELECT LAST_INSERT_ID()");
        $return=$records->fetchAll(PDO::FETCH_ASSOC);

        return $return[0]['LAST_INSERT_ID()'];
    }

    function deleteCommand($command){
        $PDO_login='usbw';
        $PDO_passwd='root';
        $PDO_text='mysql:host=localhost;dbname=dziekanat;charset=utf8;encoding=utf8;port=3307';
        try {$db = new PDO($PDO_text, $PDO_passwd, $PDO_login);}
        catch (PDOException $e) {return "Failed to connect database!: " . $e->getMessage() . "<br/>";}
        $return = $db->exec($command);
        return $return;
    }