<?php
/**
 * Created by PhpStorm.
 * User: Darqwski
 * Date: 2018-10-25
 * Time: 22:33
 */
include ("RequestFunctions/RequestFunctions.php");
include_once('ServerLogs/ServerLog.php');

define("REQUEST_OK","REQUEST_OK");
define("REQUEST_WRONG_PERMISSION","REQUEST_WRONG_PERMISSION");
define("REQUEST_SOMETHING_WRONG","REQUEST_SOMETHING_WRONG");
define("REQUEST_WRONG_TYPE","REQUEST_SOMETHING_WRONG");
define("REQUEST_WRONG_ACTION","REQUEST_SOMETHING_WRONG");

class RequestFormat{
    private $requestType;
    private $requestAction;
    private $permissionRequired;
    private $functionName;
    public function __construct($requestType,$requestAction,$permissionRequired,$functionName){
        $this->requestType=$requestType;
        $this->requestAction=$requestAction;
        $this->permissionRequired=$permissionRequired;
        $this->functionName=$functionName;
    }
    public function checkRequest( $type, $action,$permission){
        if($type != $this->requestType)return REQUEST_WRONG_TYPE;
        if($action != $this->requestAction)return REQUEST_WRONG_ACTION;
        if(!Permissions::checkPermissions($permission,$this->permissionRequired))return REQUEST_WRONG_PERMISSION;
        return REQUEST_OK;
    }
    public function executeRequest($body){

        $function =  $this->functionName;
        return $function($body);
    }
}
class RequestReceiver{
  private $requestModules = Array();

    /**
     * @param RequestFormat $requestModules
     */
    public function addRequestModule(RequestFormat $requestModule){
        array_push($this->requestModules , $requestModule);
    }
    public function checkRequestModules($type,$action,$permission){
        $body = file_get_contents("php://input");
        for($i=0;$i<count($this->requestModules);$i++){

            $functionResult = $this->requestModules[$i]->checkRequest($type,$action,$permission);

            if($functionResult === REQUEST_WRONG_ACTION) continue;
            if($functionResult === REQUEST_WRONG_TYPE) continue;
            if($functionResult === REQUEST_WRONG_PERMISSION)return buildMessage("You don't have permission to do this action");
            if($functionResult === REQUEST_OK) {
                $responseCode = 200;
                $data = '';
                try{
                    $data = $this->requestModules[$i]->executeRequest($body);
                }   catch (Exception $e){
                    $responseCode = $e->getCode();
                }
                ServerLog::saveRequestToDatabase($type,$action,$responseCode);
                return $data;
            }

        }
        return buildMessage("There is no action with these parametres");
    }
}