<?php

require 'private/funcs.php';
require 'private/constants.php';

if(isset($_REQUEST["submit"])){

    $username = $_REQUEST[COLUMN_USERNAME];
    $password = $_REQUEST[COLUMN_PASSWORD];
    $deviceId = $_REQUEST[COLUMN_DEVICE_ID];

    if (DEBUG) {
        vfprintf($fp, "username : %s\n", $username);
        vfprintf($fp, "password : %s\n", $password);
        vfprintf($fp, "deviceId : %s\n", $deviceId);        
    }

    $conn = db_connect();
   
    $userId = getUserId($conn, $username);
    $authPassword = getPassword($conn, $userId);
    if($authPassword == $password){
        // Add the user to the list of active users
        $res = addActiveUser($conn, $userId, $deviceId);
        if ($res[KEY_ERROR_REASON]) {
            return json_encode($res);
        }
        if (DEBUG) {
            vfprintf($fp, "%s\n", "Login authentication success");
        }
        $res = array(KEY_ERROR_MSG => LOGIN_AUTHENTICATION_SUCCESS);
    } else {
        if (DEBUG) {
            vfprintf($fp, "%s\n", "Login authentication failure");
        }
        $res = array(KEY_ERROR_MSG => LOGIN_AUTHENTICATION_FAILED);
    }

    $conn = db_disconnect($conn);
    
    echo json_encode($res);
    
}


?>
