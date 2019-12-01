<?php class Permissions{
    private static $noPermission = "There is no permision";
    public static $permissionsList = Array();
    public static $permissionNumbers=Array(1,2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47);
    public static $permissionLength=0;
    public static function addPermission($name){
        array_push(self::$permissionsList,$name);
        self::$permissionLength++;
    }
    /*
    For usage
    */
    public static function getPermission( $name){
        for($i=0;$i<self::$permissionLength;$i++)if(self::$permissionsList[$i] == $name)
            return self::$permissionNumbers[$i];
        return self::$noPermission;
    }
    /*
    For one permission
    */
    public static function checkPermission($userPerm, $perm){
        for($i=0;$i<self::$permissionLength;$i++)if(self::$permissionsList[$i] == $perm){
            if($userPerm%self::$permissionNumbers[$i]==0)return true;
            return false;
        }
        return false;
    }
    /*
    For few permission or Array
    */
    public static function checkPermissions(  $userPerm, Array $perm){
        $all = 1;
        for($i=0;$i<count(self::$permissionsList);$i++)
            if(in_array(self::$permissionsList[$i],$perm))
                $all *=self::$permissionNumbers[$i];
        if($userPerm%$all  == 0)return true;
        return false;
    }
    /**
    Function for checking single permition
     */
    private static function isVariationOK($variation,$hash,$password){
        $all = 1;
        for($i=0;$i<count($variation);$i++)
            $all*=$variation[$i];
        //echo "password.all == hash $all</br>";
        //echo md5($password.$all)." == $hash</br>";
        //echo md5($password.$all)===$hash;
        if(md5($all)==$hash)return true;
        return false;
    }
    /**
    Recursive function to make variation of all elements of permission
    F.E
    Permissions 2 3 5
    Checks 2 3 5 6 10 15 30
    if 6 match return array of 2,3
     */
    private static function recursivePermission($prev,$hash,$password,$number){
        if(self::isVariationOK($prev,$hash,$password))
            return $prev;
        if($number >=self::$permissionLength)
            return 1;
        $var = self::recursivePermission($prev,$hash,$password,$number+1);
        if($var != 1) return $var;
        array_push($prev,self::$permissionNumbers[$number]);
        return self::recursivePermission($prev,$hash,$password,$number+1);
    }
    /*
    Function to get permission from database
    */
    public static function buildPermission($password,$hash){
        
        return $password;
    }
    public static function getAllPermissions($value){
        $perms = Array();
        for($i=0;$i<self::$permissionLength;$i++){
            if(self::checkPermission($value,self::$permissionsList[$i])){
                array_push($perms,self::$permissionsList[$i]);
            }
        }
        return $perms;
    }
}
define("PERM_NO_PERMISSION","PERM_NO_PERMISSION");
define("PERM_ALL","PERM_ALL");

define("PERM_USERS","PERM_USERS");
define("PERM_LOGS","PERM_LOGS");
define("PERM_REPORT","PERM_REPORT");
define("PERM_PREMIUM","PERM_PREMIUM");
define("PERM_PRESENCE","PERM_PRESENCE");


Permissions::addPermission(PERM_ALL); //2
Permissions::addPermission(PERM_USERS); //3
Permissions::addPermission(PERM_LOGS); //5
Permissions::addPermission(PERM_REPORT); //7
Permissions::addPermission(PERM_PREMIUM); //11
Permissions::addPermission(PERM_PRESENCE); //13

?>