<?php

require 'private/funcs.php';

if(isset($_REQUEST["submit"])){

    $userDetails = array();

    $userDetails[COLUMN_USERNAME] = $_REQUEST[COLUMN_USERNAME];
    $userDetails[COLUMN_PASSWORD] = $_REQUEST[COLUMN_PASSWORD];
    $userDetails[COLUMN_FB_ID] = $_REQUEST[COLUMN_FB_ID];
    $userDetails[COLUMN_DISPLAY_NAME] = $_REQUEST[COLUMN_DISPLAY_NAME];
    $userDetails[COLUMN_FIRST_NAME] = $_REQUEST[COLUMN_FIRST_NAME];
    $userDetails[COLUMN_LAST_NAME] = $_REQUEST[COLUMN_LAST_NAME];
    $userDetails[COLUMN_AVATAR] = $_REQUEST[COLUMN_AVATAR];
    $userDetails[COLUMN_DOB] = $_REQUEST[COLUMN_DOB];
    $userDetails[COLUMN_GENDER] = $_REQUEST[COLUMN_GENDER];
    $userDetails[COLUMN_CONFIRM_CODE] = md5(uniqid(rand()));

    if (DEBUG_ECHO) {
        echo "username : " . $userDetails[COLUMN_USERNAME] . "\n <br />";
        echo "password : " . $userDetails[COLUMN_PASSWORD] . "\n <br />";
        echo "confirmCode : " . $userDetails[COLUMN_CONFIRM_CODE] . "\n <br />";
        echo "fb id : " . $userDetails[COLUMN_FB_ID] . "\n <br />";   
    }

    $conn = db_connect();
    
    $result = signup($conn, json_encode($userDetails));
    if ($result[KEY_ERROR_REASON]) {
        return json_encode($result);
    }
    
    if (DEBUG_ECHO) {
	    echo "About to send confirmation mail" . "\n <br />";
	}
    
    // ---------------- SEND CONFIRMATION MAIL ----------------
    $to = $userDetails[COLUMN_USERNAME];    // 'TO' field of Email
    $passkey = $userDetails[COLUMN_CONFIRM_CODE];
    $subject = CONFIRMATION_MAIL_SUBJECT;
    // Message body
    $message="Your Comfirmation link \r\n";
    $message.="Click on this link to activate your account \r\n";
    $message.="http://www.indiansglobally.com/guesstheword/Jumble_game/" .
                "confirmation.php?passkey=" . $passkey;
                
    if (DEBUG_ECHO) {
	    echo "Before sending confirmation mail" . "\n <br />";
	    echo "to : " . $to . "\n <br />";
	    echo "passkey : " . $passkey . "\n <br />";
	}
    
    $isSent = mail($to, $subject, $message, $header);
    
    if($isSent){
        $res = array(KEY_ERROR_MSG => SIGN_UP_SUCCESS . $to);
    } else {
        $res = array(KEY_ERROR_MSG => SIGN_UP_FAILURE,
                        KEY_ERROR_REASON => CONFIRMATION_MAIL_DELIVERY_FAILURE);
    }
    
    if (DEBUG_ECHO) {
	        echo "signup : res : " . json_encode($res) . "\n <br />";
	}
	
	db_disconnect($conn);
    
    return json_encode($res);
    
}

/*
if (!($fp = fopen('log.txt', 'a+'))) {
			print ("unable to open file\n");
			die ("could not open file...\n");
			return;
}
    
$data = $_REQUEST['data'];
$data_removed_slashes = stripslashes ($_REQUEST['data']);

$decoded_signup_data = json_decode($data_removed_slashes);

$username = $decoded_signup_data->{COLUMN_USERNAME}; //vfprintf($fp, "sql : %s\n", "username is ".$username);
$display_name = $decoded_signup_data->{COLUMN_DISPLAY_NAME}; 	//vfprintf($fp, "sql : %s\n", $display_name);
$password = $decoded_signup_data->{COLUMN_PASSWORD}; //vfprintf($fp, "sql : %s\n", $password);
$fb_id = $decoded_signup_data->{COLUMN_FB_ID};	//vfprintf($fp, "sql : %s\n", $fb_id);
$gender = $decoded_signup_data->{COLUMN_GENDER};  //vfprintf($fp, "sql : %s\n", $gender);

//echo "details are ".$username.$password.$display_name.$fb_id.$gender;

$conn = db_connect();
$userId = getUserId($conn,$username);
//echo "userId : " . $userId . "<br />";
$istempuserexists = isTempUserExisting($conn,$username);

//echo "userdetails exists ".$userdetails."  is temp exists ".$istempuserexists."\n";

if($userId == null && !($istempuserexists)){

    //echo "userdetails == null && isTempUserExists == false";

    mysql_select_db('guesstheword');
    // table name
    $tbl_name='temp_members_db';

    // Random confirmation code
    $confirm_code=md5(uniqid(rand())); 

    //echo $confirm_code; 
    if (DEBUG) {
        vfprintf($fp, "sql : %s\n", "details are ".$username.$password.$display_name.$fb_id.$gender);
    }
    
    // signup
    $result = signup($conn, $data_removed_slashes);
    if ($result[KEY_ERROR_REASON]) {
        //echo "error : " . $result[KEY_ERROR_MSG] . "<br />";
        //echo "error reason : " . $result[KEY_ERROR_REASON] . "<br />";
        return json_encode($result);
    }

    
    // Insert data into database
    $sql="INSERT INTO $tbl_name(confirm_code, username, displayName, password, fb_id, gender)VALUE
    ('$confirm_code','$username' ,'$display_name','$password','$fb_id','$gender' )";
    $result=mysql_query($sql);

    //echo $sql;
    if($result){
        // ---------------- SEND MAIL FORM ----------------
        // send e-mail to ...
        $to=$username;
        //echo 'sending mail to ' . $to;
        // Your subject
        $subject="Your confirmation link here";
        // From
        $header="from: your name <your email>";
        // Your message
        $message="Your Comfirmation link \r\n";
        $message.="Click on this link to activate your account \r\n";
        $message.="http://www.indiansglobally.com/guesstheword/Jumble_game/confirmation.php?passkey=$confirm_code";
        // send email
        $sentmail = mail($to,$subject,$message,$header);
    } else {  // if not found
        $res = array(KEY_ERROR_MSG => SIGN_UP_FAILURE,KEY_ERROR_REASON => MAIL_NOT_FOUND);
    }

    // if the mail is succesfully sent
    if($sentmail){
        $res = array(KEY_ERROR_MSG => SIGN_UP_SUCCESS);
    } else {
        $res = array(KEY_ERROR_MSG => SIGN_UP_FAILURE,KEY_ERROR_REASON => MAIL_NOT_SENT);
    }

}else{
    $res = array(KEY_ERROR_MSG => SIGN_UP_FAILURE,KEY_ERROR_REASON => USER_ALREADY_EXISTS);
}

echo json_encode($res);

*/

?>


