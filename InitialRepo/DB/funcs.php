<?php

if (!defined ("_JUMBLE_GAME_DB_FUNCS_"))
{
	define ("_JUMBLE_GAME_DB_FUNCS_", 1);
	define("DEBUG", false);
	
	require 'constants/constants.php';
	
	if (DEBUG) {
		if (!($fp = fopen('/var/www/www.test.com/htdocs/test_proj/server_log.txt', 'w'))) {
			print ("unable to open file\n");
			die ("could not open file...\n");
			return;
		}
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function db_connect($dbuser = 'sampadm', $dbpass = 'secret') {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			//print 'DB_HOST : ' . DB_HOST . ', user : ' . $dbuser . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			//vfprintf($fp, "DB_HOST : %s, user : %s\n", DB_HOST, $dbuser);
			
		}
		
		$conn = mysql_connect(DB_HOST, $dbuser, $dbpass);
		if (!$conn) {
			die('Could not connect: ' . mysql_error() . '<br />');
		}
		//echo 'Connected to database' . '<br />';
		if (DEBUG) {
			//print 'connection id : ' . $conn . '<br />';
			vfprintf($fp, "connection id : %s\n", $conn);
		}
		
		return $conn;
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function db_disconnect($conn) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			//print 'connection : ' . $conn . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "connection : %s\n", $conn);
		}
		
		mysql_close($conn);
		//echo 'Disconnected from database' . '<br />';
		//vfprintf($fp, "%s\n", "Disconnected from database");
		
		if (DEBUG) {
			//print 'database : ' . DATABASE() . '<br />';
			//print 'recent connection id : ' . CONNECTION_ID() . '<br />';
		}
		
	}
	
	/* Adds a new user */
	function signup($conn, $user_entry_json) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			//print 'json object received : ' . $user_entry_json . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "json object received : %s\n", $user_entry_json);
		}
		
		$jsonobj = json_decode($user_entry_json);
		$username = $jsonobj->{COLUMN_USERNAME};
		$password = $jsonobj->{COLUMN_PASSWORD};
		$display_name = $jsonobj->{COLUMN_DISPLAY_NAME};
		$first_name = $jsonobj->{COLUMN_FIRST_NAME};
		$last_name = $jsonobj->{COLUMN_LAST_NAME};
		$avatar = $jsonobj->{COLUMN_AVATAR};
		$dob = $jsonobj->{COLUMN_DOB};
		$gender = $jsonobj->{COLUMN_GENDER};
		
		if (DEBUG) {
			/*
			 print 'Details of the new user are :' . '<br />';
			 print COLUMN_USERNAME . ' : ' . $username . '<br />';
			 print COLUMN_PASSWORD . ' : ' . $password . '<br />';
			 print COLUMN_DISPLAY_NAME . ' : ' . $display_name . '<br />';
			 print COLUMN_FIRST_NAME . ' : ' . $first_name . '<br />';
			 print COLUMN_LAST_NAME . ' : ' . $last_name . '<br />';
			 print COLUMN_AVATAR . ' : ' . $avatar . '<br />';
			 print COLUMN_DOB . ' : ' . $dob . '<br />';
			 print COLUMN_GENDER . ' : ' . $gender . '<br />';
			 */
			
			vfprintf($fp, "%s\n", "Details of the new user are :");
			vfprintf($fp, "%s : %s\n", COLUMN_USERNAME, $username);
			vfprintf($fp, "%s : %s\n", COLUMN_PASSWORD, $password);
			vfprintf($fp, "%s : %s\n", COLUMN_DISPLAY_NAME, $display_name);
			vfprintf($fp, "%s : %s\n", COLUMN_FIRST_NAME, $first_name);
			vfprintf($fp, "%s : %s\n", COLUMN_LAST_NAME, $last_name);
			vfprintf($fp, "%s : %s\n", COLUMN_AVATAR, $avatar);
			vfprintf($fp, "%s : %s\n", COLUMN_DOB, $dob);
			vfprintf($fp, "%s : %s\n", COLUMN_GENDER, $gender);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Creating new user entry into table 'users'
		$sql = "INSERT INTO " . TABLE_USERS .
			"(" . COLUMN_USERNAME . "," . COLUMN_DISPLAY_NAME . "," . COLUMN_FIRST_NAME . "," . 
			COLUMN_LAST_NAME . "," . COLUMN_AVATAR . "," . COLUMN_DOB . "," . COLUMN_GENDER . ")".
			"VALUES('$username','$display_name','$first_name','$last_name', '$avatar' , '$dob','$gender')";
		
		$retval = mysql_query( $sql, $conn );
		if(! $retval )
		{
			vfprintf($str, "%s : %s\n", SIGN_UP_FAILURE, mysql_error());
			$result = array(KEY_ERROR_MSG => SIGN_UP_FAILURE, KEY_ERROR_REASON => mysql_error());
			vfprintf($str, "%s\n", $result);
			return json_encode($result);
			//die('Could not enter data : ' . mysql_error() . '<br />');
		}
		//print "User " . $username . " created successfully\n" . '<br />';
		vfprintf($fp, "User %s created successfully\n", $username);
		
		// Storing password into table 'passwords'
		$sql = "INSERT INTO " . TABLE_PASSWORDS .
			" (" . COLUMN_USERNAME . " , " . COLUMN_PASSWORD . ") ".
			"VALUES( " . $username . " , '$password' )";
		
		if (DEBUG) {
			//print "sql : " . $sql . '<br />';
			vfprintf($fp, "sql : %s\n", $sql);
		}
		
		$retval = mysql_query( $sql, $conn );
		if(! $retval )
		{
			vfprintf($str, "%s : %s\n", SIGN_UP_FAILURE, mysql_error());
			$result = array(KEY_ERROR_MSG => SIGN_UP_FAILURE, KEY_ERROR_REASON => mysql_error());
			vfprintf($str, "%s\n", $result);
			return json_encode($result);
			//die('Could not enter data : ' . mysql_error() . '<br />');
		}
		
		if (DEBUG) {
			//print "Password stored successfully\n" . '<br />';
			vfprintf($fp, "%s\n", "Password stored successfully");
		}
		
		vfprintf($str, "%s : %s\n", SIGN_UP_SUCCESS, mysql_error());
		$result = array(KEY_ERROR_MSG => SIGN_UP_SUCCESS, KEY_ERROR_REASON => mysql_error());
		vfprintf($str, "%s\n", $result);
		return json_encode($result);
		
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function get_user_info($conn, $username) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
		}
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function getPassword($conn, $username) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			//print 'username : ' . $username . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = 'SELECT ' . COLUMN_PASSWORD . ' FROM ' . TABLE_PASSWORDS .
			' WHERE ' . COLUMN_USERNAME . ' = ' . "'" . $username . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		
		$ret = mysql_query( $sql, $conn );
		
		if (!$ret) {
			$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_USERS_FAILURE, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$row = mysql_fetch_array($ret);
		if (DEBUG) {
			vfprintf($fp, "retval : %s\n", $row[COLUMN_USER_ID]);
		}
		
		return $row[COLUMN_PASSWORD];
	}
	
	/* Adds the user to the list of online users */
	function addOnlineUser($conn, $username, $deviceId) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
		}
		
		print __FUNCTION__ . ' : entered' . '<br />';
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "INSERT INTO " . TABLE_ONLINE_USERS .
			" (" . COLUMN_USERNAME . " , " . COLUMN_DEVICE_ID . ") " . 
			"VALUES( '" . $username . "' , " . $deviceId . " )";
		
		$retval = mysql_query( $sql, $conn );
		
		if (!$retval) {
			vfprintf($str, "%s : %s\n", ADDING_ONLINE_USER_FAILED, mysql_error());
			$result = array(KEY_ERROR_MSG => ADDING_ONLINE_USER_FAILED, KEY_ERROR_REASON => mysql_error());
			vfprintf($str, "%s\n", $result);
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => ADDING_ONLINE_USER_SUCCESS);
		return $result;
	}
	
	/* Get random users */
	function getRandomUsers($conn, $username) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
			vfprintf($fp, "db : %s\n", JUMBLE_GAME_DB);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "SELECT " . COLUMN_USERNAME . "," . COLUMN_DISPLAY_NAME . "," . COLUMN_GENDER .
			"," . COLUMN_AVATAR . " FROM " . TABLE_USERS . " ORDER BY RAND() ASC LIMIT 50"; 
		
		$retval =  mysql_query($sql, $conn);
		if (DEBUG) {
			vfprintf($fp, "random users : %s\n", $sql);
		}
		if (!$retval) {
			$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_USERS_FAILURE, KEY_ERROR_REASON => mysql_error());
			vfprintf($str, "%s\n", $result);
			return json_encode($result);
		}
		
		$row_count=mysql_num_rows($retval);
		
		if (DEBUG) {
			vfprintf($fp, "count : %s\n", $row_count);
		}
		
		$random_users = array();
		
		while ($user_entry = mysql_fetch_assoc($retval)) {
			
			if (DEBUG) {
				vfprintf($fp, "username : %s\n", $user_entry[COLUMN_USERNAME]);
				vfprintf($fp, "display_name : %s\n", $user_entry[COLUMN_DISPLAY_NAME]);
				vfprintf($fp, "gender : %s\n", $user_entry[COLUMN_GENDER]);
			}
			
			$user = array();
			$user[COLUMN_USERNAME] = $user_entry[COLUMN_USERNAME];
			$user[COLUMN_DISPLAY_NAME] = $user_entry[COLUMN_DISPLAY_NAME];
			$user[COLUMN_GENDER] = $user_entry[COLUMN_GENDER];
			
			$sql = "SELECT * FROM " . TABLE_ONLINE_USERS . 
				" WHERE " . COLUMN_USERNAME . " = '" . $user[COLUMN_USERNAME] . "'";
			
			$ret = mysql_query($sql, $conn);
			if (DEBUG) {
				vfprintf($fp, "online user sql statement : %s\n", $sql);
				vfprintf($fp, "ret : %s\n", $ret);
			}
			
			if (!$ret) {
				$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_USERS_FAILURE, KEY_ERROR_REASON => mysql_error());
				vfprintf($str, "%s\n", $result);
				return json_encode($result);
			}
			
			$row = mysql_fetch_array($ret);
			if ($row[COLUMN_USERNAME]) {
				$user[COLUMN_USER_STATUS] = TRUE;
				vfprintf($fp, "%s\n", "user online...........!");
			} else {
				$user[COLUMN_USER_STATUS] = FALSE;
				vfprintf($fp, "%s\n", "user offline...........!");
			}
			
			$sql = "SELECT * FROM " . TABLE_SCORES . 
				" WHERE " . COLUMN_USERNAME . " = '" . $user[COLUMN_USERNAME] . "'";
			
			$ret = mysql_query($sql, $conn);
			if (DEBUG) {
				vfprintf($fp, "online user sql statement : %s\n", $sql);
				vfprintf($fp, "ret : %s\n", $ret);
			}
			
			if (!$ret) {
				$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_USERS_FAILURE, KEY_ERROR_REASON => mysql_error());
				vfprintf($str, "%s\n", $result);
				return json_encode($result);
			}
			
			$row = mysql_fetch_array($ret);
			if ($row[COLUMN_USERNAME]) {
				$user[COLUMN_SCORE] = $row[COLUMN_SCORE];
				//vfprintf($fp, "%s\n", "user online...........!");
			} else {
				$user[COLUMN_SCORE] = 0;
				//vfprintf($fp, "%s\n", "user offline...........!");
			}
			
			array_push($random_users, $user);
			
		}
		
		if (DEBUG) {
			vfprintf($fp, "random_users : %s\n", $random_users);
			
			foreach($random_users as $arr) {
				vfprintf($fp, "username : %s\n", $arr[COLUMN_USERNAME]);
				vfprintf($fp, "user status : %s\n", $arr[COLUMN_USER_STATUS]);
			}
		}
		
		echo json_encode($random_users);
	}
	
	/* Get random puzzles */
	function getRandomPuzzles($conn) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
			vfprintf($fp, "db : %s\n", JUMBLE_GAME_DB);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "SELECT " . COLUMN_PUZZLE . "," . COLUMN_HINT_ONE . "," . COLUMN_COMMENT .
			" FROM " . TABLE_PUZZLES . " ORDER BY RAND() ASC LIMIT 50"; 
		
		$retval =  mysql_query($sql, $conn);
		if (DEBUG) {
			vfprintf($fp, "random users : %s\n", $sql);
		}
		if (!$retval) {
			$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_PUZZLES_FAILURE, KEY_ERROR_REASON => mysql_error());
			vfprintf($str, "%s\n", $result);
			return json_encode($result);
		}
		
		$row_count=mysql_num_rows($retval);
		
		if (DEBUG) {
			vfprintf($fp, "count : %s\n", $row_count);
		}
		
		$random_puzzles = array();
		
		while ($user_entry = mysql_fetch_assoc($retval)) {
			if (DEBUG) {
				vfprintf($fp, "username : %s\n", $user_entry[COLUMN_USERNAME]);
				vfprintf($fp, "display_name : %s\n", $user_entry[COLUMN_DISPLAY_NAME]);
				vfprintf($fp, "gender : %s\n", $user_entry[COLUMN_GENDER]);
			}
			
			$user = array();
			$user[COLUMN_PUZZLE] = $user_entry[COLUMN_PUZZLE];
			$user[COLUMN_HINT_ONE] = $user_entry[COLUMN_HINT_ONE];
			$user[COLUMN_COMMENT] = $user_entry[COLUMN_COMMENT];
			
			array_push($random_puzzles, $user);
		}
		echo json_encode($random_puzzles);
	}
}

?>
