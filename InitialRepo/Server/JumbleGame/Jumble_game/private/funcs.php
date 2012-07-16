<?php

if (!defined ("_JUMBLE_GAME_DB_FUNCS_"))
{
	//	echo "in functions page";
	define ("_JUMBLE_GAME_DB_FUNCS_", 1);
	define("DEBUG", false);
	
	require 'constants.php';
	
	if (DEBUG) {
		if (!($fp = fopen('log.txt', 'w'))) {
			print ("unable to open file\n");
			die ("could not open file...\n");
			return;
		}
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function db_connect($dbuser = DB_USERNAME, $dbpass = DB_PASSWORD) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "db user : %s\n", $dbuser);
		}
		
		$conn = mysql_connect(DB_HOST, $dbuser, $dbpass);
		if (!$conn) {
			die('Could not connect: ' . mysql_error() . '<br />');
		}
		//echo 'Connected to database' . '<br />';
		if (DEBUG) {
			vfprintf($fp, "connection id : %s\n", $conn);
		}
		
		return $conn;
		
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function db_disconnect($conn) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "connection : %s\n", $conn);
		}
		
		mysql_close($conn);
	}
	
	/* Takes the username as argument and returns the corresponding user id */
	function getUserId($conn, $username) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Retrieving user id from given username
		$sql = "SELECT " . COLUMN_USER_ID . " FROM " . TABLE_USERS . " WHERE " . COLUMN_USERNAME . "='" . $username . "'";
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", ERROR_RETRIEVING_USERNAME_FROM_USERID);
			$result = array(KEY_ERROR_MSG => ERROR_RETRIEVING_USERNAME_FROM_USERID, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		$count=mysql_num_rows($retval);
		$user_entry = mysql_fetch_assoc($retval);
		$user_id = $user_entry[COLUMN_USER_ID];
		if (DEBUG) {
			vfprintf($fp, "user_id : %s\n", $user_id);
		}
		return $user_id;
	}
	
	/* Takes the username as argument and returns the corresponding user id
	 * from users list who are not confirmed
	 */
	function getUserToConfirmId($conn, $username) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Retrieving user id from given username
		$sql = "SELECT " . COLUMN_USER_ID . " FROM " . TABLE_USERS_TO_CONFIRM . 
		        " WHERE " . COLUMN_USERNAME . "='" . $username . "'";
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		if (DEBUG_ECHO) {
		    echo "sql : " . $sql . "<br />";
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", ERROR_RETRIEVING_USERNAME_FROM_USERID);
			$result = array(KEY_ERROR_MSG => ERROR_RETRIEVING_USERNAME_FROM_USERID, 
			            KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		$count=mysql_num_rows($retval);
		$user_entry = mysql_fetch_assoc($retval);
		$user_id = $user_entry[COLUMN_USER_ID];
		if (DEBUG) {
			vfprintf($fp, "user_id : %s\n", $user_id);
		}
		if (DEBUG_ECHO) {
		    echo "userId : " . $user_id . "<br />";
		}
		return $user_id;
	}
	
	/* Adds a new user */
	function signup($conn, $userDetails) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "json object received : %s\n", $userDetails);
		}
		
		$jsonobj = json_decode($userDetails);
		$username = $jsonobj->{COLUMN_USERNAME};
		$fb_id = $jsonobj->{COLUMN_FB_ID};
		$password = $jsonobj->{COLUMN_PASSWORD};
		$display_name = $jsonobj->{COLUMN_DISPLAY_NAME};
		$first_name = $jsonobj->{COLUMN_FIRST_NAME};
		$last_name = $jsonobj->{COLUMN_LAST_NAME};
		$avatar = $jsonobj->{COLUMN_AVATAR};
		$dob = $jsonobj->{COLUMN_DOB};
		$gender = $jsonobj->{COLUMN_GENDER};
		$confirmCode = $jsonobj->{COLUMN_CONFIRM_CODE};
		
		if (DEBUG) {
			vfprintf($fp, "%s\n", "Details of the new user are :");
			vfprintf($fp, "%s : %s\n", COLUMN_USERNAME, $username);
			vfprintf($fp, "%s : %s\n", COLUMN_FB_ID, $fb_id);
			vfprintf($fp, "%s : %s\n", COLUMN_PASSWORD, $password);
			vfprintf($fp, "%s : %s\n", COLUMN_DISPLAY_NAME, $display_name);
			vfprintf($fp, "%s : %s\n", COLUMN_FIRST_NAME, $first_name);
			vfprintf($fp, "%s : %s\n", COLUMN_LAST_NAME, $last_name);
			vfprintf($fp, "%s : %s\n", COLUMN_AVATAR, $avatar);
			vfprintf($fp, "%s : %s\n", COLUMN_DOB, $dob);
			vfprintf($fp, "%s : %s\n", COLUMN_GENDER, $gender);
			vfprintf($fp, "%s : %s\n", COLUMN_CONFIRM_CODE, $confirmCode);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Creating new user entry into table 'users'
		$sql = "INSERT INTO " . TABLE_USERS .
			"(" . COLUMN_USERNAME . "," . COLUMN_FB_ID . "," . COLUMN_DISPLAY_NAME . "," . 
			COLUMN_FIRST_NAME . "," . COLUMN_LAST_NAME . "," . COLUMN_AVATAR . "," . 
			COLUMN_DOB . "," . COLUMN_GENDER . "," . COLUMN_ACTIVATION_CODE . "," . 
			COLUMN_IS_ACTIVATED . ")". "VALUES('$username','$fb_id','$display_name',
			'$first_name','$last_name','$avatar','$dob','$gender','$confirmCode','false')";
			
		if (DEBUG_ECHO) {
	        echo "sql : " . $sql . "\n <br />";
	    }
		
		$retval = mysql_query( $sql, $conn );
		if(!$retval)
		{
			$result = array(KEY_ERROR_MSG => SIGN_UP_FAILURE, KEY_ERROR_REASON => mysql_error());
			echo "result : " . json_encode($result) . "\n";
			return $result;
		}
		//vfprintf($fp, "User %s created successfully\n", $username);
		if (DEBUG_ECHO) {
	        echo "user registered successfully" . "\n <br />";
	    }
	    
	    $userId = getUserId($conn, $username);
	    if (!$userId) {
	        echo "userId is null";
	        return;
	    }
		
		// Storing password into table 'passwords'
		$sql = "INSERT INTO " . TABLE_PASSWORDS .
			" (" . COLUMN_USER_ID . " , " . COLUMN_PASSWORD . ") ".
			"VALUES( '" . $userId . "' , '" . $password . "' )";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		if (DEBUG_ECHO) {
	        echo "sql : " . $sql . "\n <br />";
	    }
		
		$retval = mysql_query( $sql, $conn );
		if(! $retval )
		{
			//vfprintf($fp, "%s : %s\n", SIGN_UP_FAILURE, mysql_error());
			$result = array(KEY_ERROR_MSG => SIGN_UP_FAILURE, KEY_ERROR_REASON => mysql_error());
			//vfprintf($fp, "%s\n", $result);
			echo "result : " . json_encode($result) . "<br />"; 
			return $result;
		}
		
		if (DEBUG) {
			vfprintf($fp, "%s\n", "Password stored successfully");
		}
		if (DEBUG_ECHO) {
    		echo "Password stored successfully" . "\n <br />";
		}
		
		$user_id = getUserId($conn, $username);
		
		// Initialize scores table
		$sql = "INSERT INTO " . TABLE_SCORES . " (" . COLUMN_USER_ID . "," . COLUMN_SCORE
			. ") VALUES('$user_id','0')";	// Default score will be zero
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		if (DEBUG_ECHO) {
	        echo "sql : " . $sql . "\n <br />";
	    }
	    
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", SIGN_UP_FAILURE);
			$result = array(KEY_ERROR_MSG => SIGN_UP_FAILURE, KEY_ERROR_REASON => mysql_error());
			return $result;
		}
		
		$result = array(KEY_ERROR_MSG => SIGN_UP_SUCCESS, KEY_ERROR_REASON => mysql_error());
		if (DEBUG_ECHO) {
	        echo "signup() : result : " . json_encode . "\n <br />";
	    }
		return $result;
		
	}
	
	/* Confirms the user signup */
	function confirmSignup($conn, $passkey) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "passkey : %s\n", $passkey);
		}
		if (DEBUG_ECHO) {
		    echo "passkey : " . $passkey . "\n <br />";
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Update user confirmation in 'users' table
	    $sql = "UPDATE " . TABLE_USERS . " SET " . COLUMN_IS_ACTIVATED . "='1' WHERE " . 
	        	COLUMN_ACTIVATION_CODE . "='" . $passkey . "'";
		if (DEBUG_ECHO) {	
	        echo "sql : " . $sql . "<br />";
	    }		
		$retval = mysql_query( $sql, $conn );
		if(!$retval)
		{
			$result = array(KEY_ERROR_MSG => INVALID_ACTIVATION_CODE, KEY_ERROR_REASON => mysql_error());
			if (DEBUG_ECHO) {	
	            echo "result : " . json_encode($result) . "<br />";
	        }
			return $result;
		}
		
		$result = array(KEY_ERROR_MSG => ACCOUNT_VERIFIED);
		return $result;
		
	}
	
	/* Checks if the FB user is already registered with our game
	 * Returns : 'true' if exists
	 * 			 'false' if doesn't exist' */
	function isFBUserExists($conn, $fb_id) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "fb id : %s\n", $fb_id);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = 'SELECT ' . COLUMN_FB_ID . ' FROM ' . TABLE_USERS .
			' WHERE ' . COLUMN_FB_ID . ' = ' . "'" . $fb_id . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		
		$retval = mysql_query( $sql, $conn );
		$row = mysql_fetch_array($retval);
		if (DEBUG) {
			vfprintf($fp, "fb id : %s\n", $row[COLUMN_FB_ID]);
		}
		if ($row[COLUMN_FB_ID]) {
			if (DEBUG) {
				vfprintf($fp, "user exists? : %s\n", 'true');
			}
			return true;
		} else {
			if (DEBUG) {
				vfprintf($fp, "user exists? : %s\n", 'false');
			}
			return false;
		}
	}
	
	/* Checks if the user exists in temp_members_db, i.e., whether the
	 * user is registered with jumble game server
	 * Returns : 'true' if exists
	 * 			 'false' if doesn't exist' */
	function isTempUserExisting($conn, $username) {
	
    	echo "isTempUserExisting : entered\n";
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "username : %s\n", $username);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = 'SELECT ' . COLUMN_USERNAME . ' FROM ' . 'temp_members_db' .
			' WHERE ' . COLUMN_USERNAME . ' = ' . "'" . $username . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		
		echo "sql : " . $sql . "<br />";
		
		$retval = mysql_query( $sql, $conn );
		$row = mysql_fetch_array($retval);
		if (DEBUG) {
			vfprintf($fp, "username : %s\n", $row[COLUMN_USERNAME]);
		}
		
		$row_counmt = mysql_num_rows($retval);
		if (DEBUG) {
			vfprintf($fp, "count : %s\n", $row_count);
		}
		
		echo "count : " . $row_count . "<br />";
		
		if ($row[COLUMN_USERNAME]) {
			if (DEBUG) {
				vfprintf($fp, "user exists? : %s\n", 'true');
			}
			return true;
		} else {
			if (DEBUG) {
				vfprintf($fp, "user exists? : %s\n", 'false');
			}
			return false;
		}
	}
	
	/* Retrieves the user details */
	function getUserDetails($conn, $user_id) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\n", $user_id);
		}
		
		if ($user_id == null) {
		    echo "user id : null\n<br />";
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "SELECT " . COLUMN_FB_ID . "," . COLUMN_USERNAME . "," . COLUMN_DISPLAY_NAME . 
			"," . COLUMN_FIRST_NAME . "," . COLUMN_LAST_NAME . "," . COLUMN_DOB . "," . 
			COLUMN_GENDER . " FROM " . TABLE_USERS . " WHERE " . COLUMN_USER_ID . "=" . $user_id;
			
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_RETRIEVING_USER_DETAILS);
			$result = array(KEY_ERROR_MSG => FAILURE_RETRIEVING_USER_DETAILS, KEY_ERROR_REASON => mysql_error());
			return $result;
		}
		
		$row = mysql_fetch_assoc($retval);
		
		$puzzle[COLUMN_FB_ID] = $row[COLUMN_FB_ID];
		$puzzle[COLUMN_USERNAME] = $row[COLUMN_USERNAME];
		$puzzle[COLUMN_DISPLAY_NAME] = $row[COLUMN_DISPLAY_NAME];
		$puzzle[COLUMN_FIRST_NAME] = $row[COLUMN_FIRST_NAME];
		$puzzle[COLUMN_LAST_NAME] = $row[COLUMN_LAST_NAME];
		$puzzle[COLUMN_DOB] = $row[COLUMN_DOB];
		$puzzle[COLUMN_GENDER] = $row[COLUMN_GENDER];
		
		return $row;
		
	}
	
	/* To connect to the database
	 Returns : connection id*/
	function getPassword($conn, $userId) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "userId : %s\n", $userId);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = 'SELECT ' . COLUMN_PASSWORD . ' FROM ' . TABLE_PASSWORDS .
			' WHERE ' . COLUMN_USER_ID . ' = ' . "'" . $userId . "'";
			
		if (DEBUG) {
			//print "sql : " . $sql . '<br />';
			vfprintf($fp, "sql : %s\n", $sql);
		}
		
		$retval = mysql_query( $sql, $conn );
		$row = mysql_fetch_array($retval);
		
		return $row[COLUMN_PASSWORD];
	}
	
	/* Adds the user to the list of online users */
	function addActiveUser($conn, $userId, $deviceId) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "userId : %s\n", $userId);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "INSERT INTO " . TABLE_ACTIVE_USERS .
			" (" . COLUMN_USER_ID . " , " . COLUMN_DEVICE_ID . ") " . 
			"VALUES( '" . $userId . "' , " . $deviceId . " )";
			
		$retval = mysql_query( $sql, $conn );
		
		if (!$retval) {
		    echo "Failed adding online user" . "<br />";
			//vfprintf($fp, "%s : %s\n", ADDING_ONLINE_USER_FAILED, mysql_error());
			$result = array(KEY_ERROR_MSG => ADDING_ONLINE_USER_FAILED, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => ADDING_ONLINE_USER_SUCCESS);
		return $result;
	}
	
	/* Get active users */
	function getActiveUsers($conn, $userId) {
	    global $fp;
	    // To hold the user ids of the active users
	    $activeUsersArray = array();
	    
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "userId : %s\n", $userId);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "SELECT " . COLUMN_USER_ID . "," . COLUMN_DEVICE_ID . " FROM " . 
		        TABLE_ACTIVE_USERS . " WHERE " . COLUMN_USER_ID . "!=" . 
		        $userId ." ORDER BY RAND() ASC LIMIT 50"; 
		        
		$retval =  mysql_query($sql, $conn);
		if (DEBUG) {
			vfprintf($fp, "online active users : %s\n", $sql);
		}
		if (!$retval) {
		    echo "getActiveUsers : returning...\n";
			$result = array(KEY_ERROR_MSG => RETRIEVING_ACTIVE_USERS_FAILURE, KEY_ERROR_REASON => mysql_error());
			vfprintf($fp, "%s\n", $result);
			return $result;
		}
		
		$row_count=mysql_num_rows($retval);
		
		if (DEBUG) {
			vfprintf($fp, "count : %s\n", $row_count);
		}
		
		while ($row = mysql_fetch_assoc($retval)) {
		    $user = array();
		    $user[COLUMN_USER_ID] = $row[COLUMN_USER_ID];
		    $user[COLUMN_DEVICE_ID] = $row[COLUMN_DEVICE_ID];
		    array_push($activeUsersArray, $user);
		}
		
		return $activeUsersArray;
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
			vfprintf($fp, "%s\n", $result);
			return json_encode($result);
		}
		
		$row_count=mysql_num_rows($retval);
		
		if (DEBUG) {
			vfprintf($fp, "count : %s\n", $row_count);
		}
		
		return json_encode(usersToJSON($conn, $retval));
		
	}
	
	/* Fills users list from the mysql query result into a json object
	 * Args :
	 * 		$cursor : mysql query result object
	 */
	function usersToJSON($conn, $cursor) {
		
		GLOBAL $fp;
		
		$random_users = array();
		
		if (DEBUG) {
			vfprintf($fp, "usersToJSON : %s\n", "entered");
		}
		
		while ($user_entry = mysql_fetch_assoc($cursor)) {
			
			if (DEBUG) {
				vfprintf($fp, "username : %s\n", $user_entry[COLUMN_USERNAME]);
				vfprintf($fp, "display_name : %s\n", $user_entry[COLUMN_DISPLAY_NAME]);
				vfprintf($fp, "gender : %s\n", $user_entry[COLUMN_GENDER]);
			}
			
			$user = array();
			$user[COLUMN_USERNAME] = $user_entry[COLUMN_USERNAME];
			$user[COLUMN_DISPLAY_NAME] = $user_entry[COLUMN_DISPLAY_NAME];
			$user[COLUMN_GENDER] = $user_entry[COLUMN_GENDER];
			
			$sql = "SELECT * FROM " . TABLE_ACTIVE_USERS .
				" WHERE " . COLUMN_USERNAME . " = '" . $user[COLUMN_USERNAME] . "'";
			
			$ret = mysql_query($sql, $conn);
			if (DEBUG) {
				vfprintf($fp, "online user sql statement : %s\n", $sql);
				//vfprintf($fp, "ret : %s\n", $ret);
			}
			
			if (!$ret) {
				$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_USERS_FAILURE, KEY_ERROR_REASON => mysql_error());
				vfprintf($fp, "failed : %s\n", $result);
				return json_encode($result);
			}
			
			if (DEBUG) {
				vfprintf($fp, "%s\n", "active user query success");
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
				vfprintf($fp, "%s\n", $result);
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
			vfprintf($fp, "users : %s\n", $random_users);
			
			foreach($random_users as $arr) {
				vfprintf($fp, "username : %s\n", $arr[COLUMN_USERNAME]);
				vfprintf($fp, "user status : %s\n", $arr[COLUMN_USER_STATUS]);
			}
		}
		
		return $random_users;
	}
	
	/* Get random puzzles */
	function getRandomPuzzles($conn) {
		
		global $fp;
		
		if (DEBUG) {
			//print __FUNCTION__ . ' : entered' . '<br />';
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "db : %s\n", JUMBLE_GAME_DB);
		}
		
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "SELECT " . COLUMN_PUZZLE_ID.",".COLUMN_PUZZLE . "," . COLUMN_HINT_ONE . "," .COLUMN_HINT_TWO.",". COLUMN_COMMENT .
			",".COLUMN_AWARD_POINTS.
			" FROM " . TABLE_PUZZLES ; 
		//" ORDER BY RAND() ASC LIMIT 50"
		$retval =  mysql_query($sql, $conn);
		if (DEBUG) {
			vfprintf($fp, "random users : %s\n", $sql);
		}
		if (!$retval) {
			$result = array(KEY_ERROR_MSG => RETRIEVING_RANDOM_PUZZLES_FAILURE, KEY_ERROR_REASON => mysql_error());
			vfprintf($fp, "%s\n", $result);
			return json_encode($result);
		}
		
		$row_count=mysql_num_rows($retval);
		
		if (DEBUG) {
			vfprintf($fp, "count : %s\n", $row_count);
		}
		
		$ret = puzzlesToJSON($retval);
		if (DEBUG) {
			vfprintf($fp, "ret : %s\n", $ret);
		}
		return $ret;
	}
	
	/* Fills puzzles from the mysql query result into a json object
	 * Args :
	 * 		$cursor : mysql query result object
	 */
	function puzzlesToJSON($cursor) {
		
		GLOBAL $fp;
		
		$puzzles = array();
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
		}
		
		while ($puzzle_entry = mysql_fetch_assoc($cursor)) {
			
			$puzzle = array();
			$puzzle[COLUMN_PUZZLE_ID] = $puzzle_entry[COLUMN_PUZZLE_ID];
			$puzzle[COLUMN_PUZZLE] = $puzzle_entry[COLUMN_PUZZLE];
			$puzzle[COLUMN_HINT_ONE] = $puzzle_entry[COLUMN_HINT_ONE];
			$puzzle[COLUMN_HINT_TWO] = $puzzle_entry[COLUMN_HINT_TWO];
			$puzzle[COLUMN_AWARD_POINTS] = $puzzle_entry[COLUMN_AWARD_POINTS];
			$puzzle[COLUMN_COMMENT] = $puzzle_entry[COLUMN_COMMENT];
			
			if (DEBUG) {
				fprintf($fp, "\tpuzzle id : %s\n", $puzzle[COLUMN_PUZZLE_ID]);
			}
			
			array_push($puzzles, $puzzle);
		}
		
		return json_encode($puzzles);
	}
	
	/* Gets the solution to a puzzle */
	function getPuzzleSolution($conn, $puzzle_id) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "puzzle_id : %s\n", $puzzle_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Get Friends list
		$sql = "SELECT " . COLUMN_SOLUTION . " FROM " . TABLE_PUZZLES . " WHERE " . COLUMN_PUZZLE_ID . 
			"=" . $puzzle_id;
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_RETRIEVING_PUZZLE_SOLUTION);
			$result = array(KEY_ERROR_MSG => FAILURE_RETRIEVING_PUZZLE_SOLUTION, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		$row_count=mysql_num_rows($retval);
		if (DEBUG) {
			vfprintf($fp, "row count : %s\n", $row_count);
		}
		
		$row = mysql_fetch_assoc($retval);
		
		return json_encode($row);
	}
	
	/* Insert a puzzle to a friend/random user from user */
	//function puzzleToFriend($conn, $puzzle_id, $user_id, $friend_id) {
	function sendPuzzleToFriend($conn, $puzzle_id, $username, $friendname, $max_time) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "puzzle_id : %s\n", $puzzle_id);
			vfprintf($fp, "user_id : %s\n", $username);
			vfprintf($fp, "friend_id : %s\n", $friend_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		$user_id = getUserId($conn, $username);
		$friend_id = getUserId($conn, $friendname);
		
		// Inserting the selected puzzle into 'user_puzzles' table
		$sql = "INSERT INTO " . TABLE_USER_PUZZLES .
			" (" . COLUMN_PUZZLE_ID . "," . COLUMN_FRIEND_ID . "," . COLUMN_USER_ID . "," . 
			COLUMN_MAX_TIME . "," .COLUMN_DATE_ASSIGNED . ") " .
			"VALUES( '" . $puzzle_id . "','" . $user_id . "','" . $friend_id . "','" . $max_time . "', now())";
		if (DEBUG) {
			vfprintf($fp, "insert puzzle : sql : %s\n", $sql);
		}
		$retval = mysql_query( $sql, $conn );
		if (!$retval) {
			vfprintf($fp, "%s : %s\n", FAILURE_INSERTING_PUZZLE_TO_USER, mysql_error());
			$result = array(KEY_ERROR_MSG => FAILURE_INSERTING_PUZZLE_TO_USER, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_INSERTING_PUZZLE);
		return json_encode($result);
		
	}
	
	/* Retrieves puzzles to user */
	function getPuzzlesToUser($conn, $arr, $user_id) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
		}
		
		return getUserPuzzles($conn, $arr, $user_id, true);
		
	}
	
	/* Retrieves puzzles by user */
	function getPuzzlesByUser($conn, $arr, $user_id) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
		}
		
		return getUserPuzzles($conn, $arr, $user_id, false);
		
	}
	
	/* Retrieves the puzzles to user or puzzles by user based on the boolean valu $isToPuzzles */
	function getUserPuzzles($conn, $arr, $id, $isToPuzzles) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "id : %s\n", $id);
		}
		
		if ($isToPuzzles) {
			$source = COLUMN_USER_ID;
		} else {
			$source = COLUMN_FRIEND_ID;
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Get puzzles to user
		/*
		 SELECT user_puzzles.puzzle_id, user_id, friend_id, maxTime, isViewed, isAnswered, isPaused, 
		 expiryDate, date_assigned, date_answered, puzzle, hint_one, hint_two, comment, award_points 
		 FROM user_puzzles, puzzles WHERE user_id=3 && puzzles.puzzle_id=user_puzzles.puzzle_id
		 */
		$sql = "SELECT " . TABLE_USER_PUZZLES . "." . COLUMN_PUZZLE_ID . "," . COLUMN_USER_ID . "," . COLUMN_FRIEND_ID . 
			"," . COLUMN_MAX_TIME . "," . COLUMN_IS_VIEWED . "," . COLUMN_IS_ANSWERED . "," . COLUMN_IS_PASSED . 
			"," . COLUMN_EXPIRY_DATE . "," . COLUMN_DATE_ASSIGNED . "," . COLUMN_DATE_ANSWERED . "," . 
			COLUMN_PUZZLE . "," . COLUMN_HINT_ONE . "," . COLUMN_HINT_TWO . "," . COLUMN_COMMENT . "," . 
			COLUMN_AWARD_POINTS . " FROM " . TABLE_USER_PUZZLES . "," . TABLE_PUZZLES . " WHERE " . $source . 
			"=" . $id . " && " . TABLE_PUZZLES . "." . COLUMN_PUZZLE_ID . "=" . TABLE_USER_PUZZLES . 
			"." . COLUMN_PUZZLE_ID;
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_RETRIEVING_PUZZLES_TO_USER);
			$result = array(KEY_ERROR_MSG => FAILURE_RETRIEVING_PUZZLES_TO_USER, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		$row_count=mysql_num_rows($retval);
		if (DEBUG) {
			vfprintf($fp, "row count : %s\n", $row_count);
		}
		
		if (!$arr) {
			$arr = array();
		}
		
		while ($row = mysql_fetch_assoc($retval)) {
			
			$puzzle = array();
			if ($isToPuzzles) {
				$puzzle[COLUMN_FRIEND_ID] = $row[COLUMN_FRIEND_ID];
			} else {
				$puzzle[COLUMN_FRIEND_ID] = $row[COLUMN_USER_ID];
			}
			$puzzle[COLUMN_PUZZLE_ID] = $row[COLUMN_PUZZLE_ID];
			$puzzle[COLUMN_MAX_TIME] = $row[COLUMN_MAX_TIME];
			$puzzle[COLUMN_IS_VIEWED] = $row[COLUMN_IS_VIEWED];
			$puzzle[COLUMN_IS_ANSWERED] = $row[COLUMN_IS_ANSWERED];
			$puzzle[COLUMN_IS_PASSED] = $row[COLUMN_IS_PASSED];
			$puzzle[COLUMN_EXPIRY_DATE] = $row[COLUMN_EXPIRY_DATE];
			$puzzle[COLUMN_DATE_ASSIGNED] = $row[COLUMN_DATE_ASSIGNED];
			$puzzle[COLUMN_DATE_ANSWERED] = $row[COLUMN_DATE_ANSWERED];
			$puzzle[COLUMN_PUZZLE] = $row[COLUMN_PUZZLE];
			$puzzle[COLUMN_HINT_ONE] = $row[COLUMN_HINT_ONE];
			$puzzle[COLUMN_HINT_TWO] = $row[COLUMN_HINT_TWO];
			$puzzle[COLUMN_AWARD_POINTS] = $row[COLUMN_AWARD_POINTS];
			$puzzle[COLUMN_COMMENT] = $row[COLUMN_COMMENT];
			
			if (DEBUG) {
				vfprintf($fp, "puzzle_id : %s\n", $puzzle[COLUMN_PUZZLE_ID]);
			}
			
			array_push($arr, $puzzle);
		}
		
		if (DEBUG) {
			vfprintf($fp, "arr:\n%s\n", json_encode($arr));
		}
		
		return json_encode($arr);
		
	}
	
	/* Updates user's puzzle view status. This updates the field isViewed to true */
	// TODO : update expiry date
	function updatePuzzleViewedStatus($conn, $user_id, $puzzle_id) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\tpuzzle_id : %s\n", $user_id, $puzzle_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		//UPDATE `jumble_game`.`user_puzzles` SET `isViewed` = '1' WHERE `user_puzzles`.`puzzle_id` =1;
		$sql = "UPDATE " . TABLE_USER_PUZZLES . " SET " . COLUMN_IS_VIEWED . "='1'" . " WHERE " . COLUMN_USER_ID .
			"='" . $user_id . "' && " . COLUMN_PUZZLE_ID . "='" . $puzzle_id . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_UPDATING_PUZZLE_VIEWED_STATUS);
			$result = array(KEY_ERROR_MSG => FAILURE_UPDATING_PUZZLE_VIEWED_STATUS, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_UPDATING_PUZZLE_VIEWED_STATUS);
		return json_encode($result);
	}
	
	/* Updates user's puzzle answered status. This updates the field isAnswered to true */
	function updatePuzzleAnsweredStatus($conn, $user_id, $puzzle_id) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\tpuzzle_id : %s\n", $user_id, $puzzle_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		//UPDATE `jumble_game`.`user_puzzles` SET `isViewed` = '1' WHERE `user_puzzles`.`puzzle_id` =1;
		$sql = "UPDATE " . TABLE_USER_PUZZLES . " SET " . COLUMN_IS_ANSWERED . "='1'," . COLUMN_DATE_ANSWERED
			. "=now() WHERE " . COLUMN_USER_ID .	"='" . $user_id . "' && " . COLUMN_PUZZLE_ID . "='" . $puzzle_id . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS);
			$result = array(KEY_ERROR_MSG => FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		// Getting the user's score and the award points of the puzzle
		$sql = "SELECT " .  COLUMN_SCORE . "," . COLUMN_AWARD_POINTS . " FROM " . 
				TABLE_SCORES . "," . TABLE_PUZZLES . " WHERE " . COLUMN_USER_ID . "=" . $user_id
				. " && " . COLUMN_PUZZLE_ID . "=" . $puzzle_id;
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS);
			$result = array(KEY_ERROR_MSG => FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$row = mysql_fetch_assoc($retval);
		$score = $row[COLUMN_SCORE];
		$awardPoints = $row[COLUMN_AWARD_POINTS];
		$score += $awardPoints;
		
		// Updating the user's score
		$sql = "UPDATE " . TABLE_SCORES . " SET " . COLUMN_SCORE . "=" . $score . 
				" WHERE " . COLUMN_USER_ID . "=" . $user_id;
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS);
			$result = array(KEY_ERROR_MSG => FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_UPDATING_PUZZLE_ANSWERED_STATUS);
		return json_encode($result);
	}
	
	/* Updates user's puzzle paused status. This updates the field isPaused to true */
	function updatePuzzlePausedStatus($conn, $user_id, $puzzle_id) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\tpuzzle_id : %s\n", $user_id, $puzzle_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		//UPDATE `jumble_game`.`user_puzzles` SET `isViewed` = '1' WHERE `user_puzzles`.`puzzle_id` =1;
		$sql = "UPDATE " . TABLE_USER_PUZZLES . " SET " . COLUMN_IS_PASSED . "='1'," . COLUMN_DATE_ANSWERED
			. "=now() WHERE " . COLUMN_USER_ID .	"='" . $user_id . "' && " . COLUMN_PUZZLE_ID . "='" . $puzzle_id . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_UPDATING_PUZZLE_PASSED_STATUS);
			$result = array(KEY_ERROR_MSG => SUCCESS_UPDATING_PUZZLE_PASSED_STATUS, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_UPDATING_PUZZLE_PASSED_STATUS);
		return json_encode($result);
	}
	
	/* New friend request */
	function newFriendRequest ($conn, $user_id, $friend_id) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\tfriend_id : %s\n", $user_id, $friend_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "INSERT INTO " . TABLE_FRIENDS . " (" . COLUMN_USER_ID . "," . COLUMN_FRIEND_ID
			. ") VALUES('$user_id','$friend_id')";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_CREATING_NEW_FRIEND_REQUEST);
			$result = array(KEY_ERROR_MSG => FAILURE_CREATING_NEW_FRIEND_REQUEST, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_CREATING_NEW_FRIEND_REQUEST);
		return json_encode($result);
	}
	
	/* Updates friend status. This updates the field isConfirmed to true */
	function updateFriendRequest ($conn, $user_id, $friend_id) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\tfriend_id : %s\n", $user_id, $friend_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "UPDATE " . TABLE_FRIENDS . " SET " . COLUMN_IS_CONFIRMED . "='1' WHERE " . 
			COLUMN_USER_ID . "='" . $user_id . "' && " . COLUMN_FRIEND_ID . "='" . $friend_id . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_UPDATING_FRIEND_REQUEST_CONFIRMATION);
			$result = array(KEY_ERROR_MSG => FAILURE_UPDATING_FRIEND_REQUEST_CONFIRMATION, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_UPDATING_FRIEND_REQUEST_CONFIRMATION);
		return json_encode($result);
	}
	
	/* Ignores friend status. This updates the field isIgnored to true */
	function ignoreFriendRequest ($conn, $user_id, $friend_id) {
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\tfriend_id : %s\n", $user_id, $friend_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		$sql = "UPDATE " . TABLE_FRIENDS . " SET " . COLUMN_IS_IGNORED . "='1' WHERE " . 
			COLUMN_USER_ID . "='" . $user_id . "' && " . COLUMN_FRIEND_ID . "='" . $friend_id . "'";
		
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_IGNORING_FRIEND_REQUEST);
			$result = array(KEY_ERROR_MSG => FAILURE_IGNORING_FRIEND_REQUEST, KEY_ERROR_REASON => mysql_error());
			return json_encode($result);
		}
		
		$result = array(KEY_ERROR_MSG => SUCCESS_IGNORING_FRIEND_REQUEST);
		return json_encode($result);
	}
	
	/* Retrieves the user's friends list 
	 * @return : the ids of the friends*/
	function getFriends($conn, $user_id) {
		
		global $fp;
		
		if (DEBUG) {
			vfprintf($fp, "%s : entered\n", __FUNCTION__);
			vfprintf($fp, "user_id : %s\n", $user_id);
		}
		
		// Selecting Jumble Game Database
		mysql_select_db(JUMBLE_GAME_DB);
		
		// Get Friends list
		$sql = "SELECT " . COLUMN_FRIEND_ID . " FROM " . TABLE_FRIENDS . " WHERE " . COLUMN_USER_ID . 
			"=" . $user_id;
		if (DEBUG) {
			vfprintf($fp, "sql : %s\n", $sql);
		}
		$retval = mysql_query($sql, $conn);
		if (!$retval) {
			vfprintf($fp, "%s\n", FAILURE_RETRIEVING_FRIENDS_LIST);
			$result = array(KEY_ERROR_MSG => FAILURE_RETRIEVING_FRIENDS_LIST, KEY_ERROR_REASON => mysql_error());
			return $result;
		}
		$row_count=mysql_num_rows($retval);
		if (DEBUG) {
			vfprintf($fp, "row count : %s\n", $row_count);
		}
		
		$i = 0;
		$friends = array();
		while ($row = mysql_fetch_assoc($retval)) {
			$friends[$i++] = $row[COLUMN_FRIEND_ID];
		}
		
		return $friends;
	}
	
}

?>
