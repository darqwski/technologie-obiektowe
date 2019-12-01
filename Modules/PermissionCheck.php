<?php
function userHasPermission($permissionName,$professionId){
    if(!isset($_SESSION['userId']))return false;
    $userPermissions = getCommand("
SELECT  `ga_permissions`.`name`,`ga_user_permission`.`professionId` FROM  `ga_user_permission` 
INNER JOIN `ga_permissions` ON `ga_permissions`.`id` = `ga_user_permission`.`permissionId`
WHERE `ga_user_permission`.`userId` = '$_SESSION[userId]'
 ");
    foreach ($userPermissions as $userPermission){
        if($userPermission['name'] == $permissionName && $professionId == $userPermission['professionId'])
            return true;
    }
    http_response_code(403);
    return false;
}
function userIsAdmin(){
    $admins = getCommand("SELECT * FROM `ga_admins`");
    $isAdmin = false;
    foreach ($admins as $admin){
        if($admin['ID'] == $_SESSION['userId'])
            $isAdmin=true;
    }
    return $isAdmin;
}
