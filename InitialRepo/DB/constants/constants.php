<?php

if (!defined ("_JUMBLE_GAME_CONSTANTS_"))
{
	define ("_JUMBLE_GAME_CONSTANTS_", 1);

	//define("JUMBLE_GAME_DB", 'jumble_game');
	define("JUMBLE_GAME_DB", 'my_project');
	define("DB_HOST", 'localhost:3036');

	/* 'jumble_game' db tables */
	define("TABLE_USERS", 'users');
	define("TABLE_FRIENDS", 'friends');
	define("TABLE_PUZZLES", 'puzzles');
	define("TABLE_SCORES", 'scores');
	define("TABLE_PASSWORDS", 'passwords');
	define("TABLE_ONLINE_USERS", 'online_users');

	/* 'jumble_game' db columns */
	define("COLUMN_USER_ID", 'user_id');
	define("COLUMN_USERNAME", 'username');
	define("COLUMN_PASSWORD", 'password');
	define("COLUMN_DISPLAY_NAME", 'display_name');
	define("COLUMN_FIRST_NAME", 'first_name');
	define("COLUMN_LAST_NAME", 'last_name');
	define("COLUMN_AVATAR", 'avatar');
	define("COLUMN_DOB", 'dob');
	define("COLUMN_GENDER", 'gender');
	define("COLUMN_SCORE", 'score');
	define("COLUMN_USER_STATUS", 'user_status');
	define("COLUMN_FRIEND_ID", 'friend_id');
	define("COLUMN_PUZZLE_ID", 'puzzle_id');
	define("COLUMN_PUZZLE", 'puzzle');
	define("COLUMN_SOLUTION", 'solution');
	define("COLUMN_HINT_ONE", 'hint_one');
	define("COLUMN_HINT_TWO", 'hint_two');
	define("COLUMN_HINT_THREE", 'hint_three');
	define("COLUMN_AWARD_POINTS", 'award_points');
	define("COLUMN_COMMENT", 'comment');
	define("COLUMN_DOE", 'doe');
	define("COLUMN_IS_USED", 'is_used');
	define("COLUMN_DEVICE_ID", "device_id");

	/* Error messages */
	define("KEY_ERROR_MSG", 'error_msg');
	define("KEY_ERROR_REASON", 'error_reason');
	define("LOGIN_AUTHENTICATION_FAILED", 'Login authentication failed. Please check your username/password');
	define("SIGN_UP_FAILURE", 'Sign up failed');
	define("SIGN_UP_SUCCESS", 'Sign up successful');
	define("ADDING_ONLINE_USER_SUCCESS", 'User online');
	define("ADDING_ONLINE_USER_FAILED", 'User offline');
	define("RETRIEVING_RANDOM_USERS_SUCCESS", 'Success getting a list of random users');
	define("RETRIEVING_RANDOM_USERS_FAILURE", 'Error getting a list of random users');
	define("RETRIEVING_RANDOM_PUZZLES_FAILURE", 'Error getting a list of random puzzles');
}

?>
