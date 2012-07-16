<?php

//include('config.php');
require 'private/funcs.php';

$conn = db_connect();

mysql_select_db('guesstheword');

// Passkey that got from link
$passkey=$_GET['passkey'];

$conn = db_connect();

$result = confirmSignup($conn, $passkey);

db_disconnect($conn);

echo json_encode($result);

/*
//echo "pass key is ".$passkey;
$tbl_name1="temp_members_db";

// Retrieve data from table where row that match this passkey
$sql1="SELECT * FROM $tbl_name1 WHERE confirm_code ='$passkey'";
$result1=mysql_query($sql1);  
$count=mysql_num_rows($result1);
//echo "count is ".$count;

// If successfully queried
if($result1){

    // Count how many row has this passkey
    $count=mysql_num_rows($result1);

    // if found this passkey in our database, retrieve data from table "temp_members_db"
    if($count==1) {

        $rows=mysql_fetch_array($result1);
        //print_r($rows);
        //echo json_encode($rows);
        $username=$rows['username'];
        $display_name=$rows['displayName'];
        $password=$rows['password'];
        $fb_id=$rows['fbId'];
        $gender=$rows['gender'];
        $tbl_name2='users';
        $tbl_name3='passwords';

        echo "rows : " . json_encode($rows);
        echo "username : " . $username . "<br />";
        echo "fb_id : " . $fb_id . "<br />";

        $result = signup($conn, json_encode($rows));
*/
/*      
        // Insert data that retrieves from "temp_members_db" into table "users"
        $sql2 = "INSERT INTO " . $tbl_name2 .
			        "(" . COLUMN_USERNAME . "," . COLUMN_FB_ID . "," . COLUMN_DISPLAY_NAME . "," . COLUMN_FIRST_NAME . "," . 
			        COLUMN_LAST_NAME . "," . COLUMN_AVATAR . "," . COLUMN_DOB . "," . COLUMN_GENDER . ")".
			        "VALUES('$username'," . $fb_id . ",'$display_name','$first_name','$last_name','$avatar','$dob','$gender')";
			
        echo "sql query : " . $sql2 . "<br />";

        $retval = mysql_query($sql2, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", "Error inserting into users table");
			$result = array(KEY_ERROR_MSG => "Error inserting into users table", KEY_ERROR_REASON => mysql_error());
			echo "result : " . json_encode($result) . "<br />";
			return $result;
		}
*/
/*
        $userId = getUserId($conn, $username);

        //echo "user id is ".$userId."\n"."username ".$username."\n";

        $sql3 = "INSERT INTO " . $tbl_name3 .
			        "(" . COLUMN_USER_ID . "," . COLUMN_PASSWORD .  ")".
			        "VALUES('$userId','$password')";
        //$sql3 = "INSERT INTO passwords(userId,password) VALUES(28,sasasa)";
        //echo "sql3 : " . $sql3 . "<br />";

        $result3=mysql_query($sql3);
        //echo "result database insertion :::: ".$result2."\n"."password insertion :: ".$result3."\n";
        //$conn = db_connect();
        //echo "*******************************************************************************";
        //echo "\nthis is important==>".$sql2."\n";
    } else {    // if not found passkey, display message "Wrong Confirmation code"
        echo "Wrong Confirmation code";
    }
*/
    /* if successfully moved data from table"temp_members_db" to table "registered_members" 
     * displays message "Your account has been activated" and 
     * don't forget to delete confirmation code from table "temp_members_db"
     */
/*    if($result2){
        echo "Your account has been activated";
        // Delete information of this user from table "temp_members_db" that has this passkey
        $sql4="DELETE FROM $tbl_name1 WHERE confirm_code = '$passkey'";
        $result4=mysql_query($sql4);
        //echo "data has been removed from temp data base ".$result4."sql query is ".$sql4;
}


}//$conn = db_disconnect($conn);
*/
?>
