<?php

if (!defined ("_JUMBLE_GAME_CONSTANTS_"))
{
	define ("_JUMBLE_GAME_CONSTANTS_", 1);

    /* 'guesstheword' database authentication constants */
	define("JUMBLE_GAME_DB", 'guesstheword');
	define("DB_HOST", 'www.indiansglobally.com');
	define("DB_USERNAME", 'guessthe');
	define("DB_PASSWORD", 'Guess123');

	/* 'guesstheword' db tables */
	define("TABLE_USERS", 'users');
	define("TABLE_FRIENDS", 'friends');
	define("TABLE_PUZZLES", 'puzzles');
	define("TABLE_SCORES", 'scores');
	define("TABLE_PASSWORDS", 'passwords');
	define("TABLE_ACTIVE_USERS", 'active_users');
	define("TABLE_USER_PUZZLES", 'user_puzzles');
	define("PHOTOS_PATH",'www.indiansglobally.com/guesstheword/Jumble_game/Images');

	/* 'guesstheword' db columns */
	define("COLUMN_USER_ID", 'userId');
	define("COLUMN_FB_ID", 'fbId');
	define("COLUMN_USERNAME", 'username');
	define("COLUMN_PASSWORD", 'password');
	define("COLUMN_DISPLAY_NAME", 'displayName');
	define("COLUMN_FIRST_NAME", 'firstName');
	define("COLUMN_LAST_NAME", 'lastName');
	define("COLUMN_AVATAR", 'avatar');
	define("COLUMN_DOB", 'dob');
	define("COLUMN_GENDER", 'gender');
	define("COLUMN_SCORE", 'score');
	define("COLUMN_USER_STATUS", 'userStatus');
	define("COLUMN_FRIEND_ID", 'friendId');
	define("COLUMN_PUZZLE_ID", 'puzzleId');
	define("COLUMN_PUZZLE", 'puzzle');
	define("COLUMN_SOLUTION", 'solution');
	define("COLUMN_HINT_ONE", 'hintOne');
	define("COLUMN_HINT_TWO", 'hintTwo');
	define("COLUMN_HINT_THREE", 'hintThree');
	define("COLUMN_AWARD_POINTS", 'awardPoints');
	define("COLUMN_COMMENT", 'comment');
	define("COLUMN_DOE", 'doe');
	define("COLUMN_IS_USED", 'isUsed');
	define("COLUMN_DEVICE_ID", 'deviceId');
	define("COLUMN_MAX_TIME", 'maxTime');
	define("COLUMN_EXPIRY_DATE", 'expiryDate');
	define("COLUMN_IS_VIEWED", 'isViewed');
	define("COLUMN_IS_ANSWERED", 'isAnswered');
	define("COLUMN_IS_PASSED", 'isPaused');
	define("COLUMN_IS_CONFIRMED", 'isConfirmed');
	define("COLUMN_IS_IGNORED", 'isIgnored');
	define("COLUMN_DATE_ASSIGNED", 'dateAssigned');
	define("COLUMN_DATE_ANSWERED", 'dateAnswered');
	
	/* Other constants */
	define("MAX_PUZZLES_TO_VIEW", '3');

	/* Error messages */
	define("MAIL_NOT_SENT",'Cannot send Confirmation link to your e-mail address');
	define("MAIL_SENT",'Your Confirmation link Has Been Sent To Your Email Address');
	define("USER_ALREADY_EXISTS",'user already exists');
	define("MAIL_NOT_FOUND",'Not found your email in our database');
	define("SUCCESS","success");
	define("FAILURE","failure");
	define("KEY_ERROR_MSG", 'error_msg');
	define("KEY_ERROR_REASON", 'error_reason');
	define("LOGIN_AUTHENTICATION_FAILED", 'Login authentication failed. Please check your username/password');
	define("LOGIN_AUTHENTICATION_SUCCESS", 'login success');
	define("SIGN_UP_FAILURE", 'Sign up failed');
	define("SIGN_UP_SUCCESS", 'Sign up successful');
	define("ADDING_ONLINE_USER_SUCCESS", 'User online');
	define("ADDING_ONLINE_USER_FAILED", 'User offline');
	define("RETRIEVING_RANDOM_USERS_SUCCESS", 'Success getting a list of random users');
	define("RETRIEVING_RANDOM_USERS_FAILURE", 'Error getting a list of random users');
	define("RETRIEVING_RANDOM_PUZZLES_FAILURE", 'Error getting a list of random puzzles');
	define("FAILURE_INSERTING_PUZZLE_TO_USER", 'Failed to puzzle a friend');
	define("FAILURE_INSERTING_PUZZLE_FROM_USER", 'Failed to add puzzle to user\'s sent puzzles list');
	define("SUCCESS_INSERTING_PUZZLE", 'Successfully sent puzzle to friend or random user');
	define("FAILURE_RETRIEVING_PUZZLES_TO_USER", 'Error retrieving puzzles to user');
	define("SUCCESS_RETRIEVING_PUZZLES_TO_USER", 'Success retrieving puzzles to user');
	define("FAILURE_RETRIEVING_PUZZLES_FROM_USER", 'Error retrieving puzzles from user');
	define("SUCCESS_RETRIEVING_PUZZLES_FROM_USER", 'Success retrieving puzzles from user');
	define("ERROR_RETRIEVING_USERNAME_FROM_USERID", 'Error retrieving username from userid');
	define("FAILURE_UPDATING_PUZZLE_VIEWED_STATUS", 'Error updating puzzle viewed status');
	define("SUCCESS_UPDATING_PUZZLE_VIEWED_STATUS", 'Success updating puzzle viewed status');
	define("FAILURE_UPDATING_PUZZLE_ANSWERED_STATUS", 'Error updating puzzle answered status');
	define("SUCCESS_UPDATING_PUZZLE_ANSWERED_STATUS", 'Success updating puzzle answered status');
	define("FAILURE_UPDATING_PUZZLE_PASSED_STATUS", 'Error updating puzzle paused status');
	define("SUCCESS_UPDATING_PUZZLE_PASSED_STATUS", 'Success updating puzzle paused status');
	define("FAILURE_CREATING_NEW_FRIEND_REQUEST", 'Error creating new friend request');
	define("SUCCESS_CREATING_NEW_FRIEND_REQUEST", 'Success creating new friend request');
	define("FAILURE_UPDATING_FRIEND_REQUEST_CONFIRMATION", 'Error updating friend request confirmed status');
	define("SUCCESS_UPDATING_FRIEND_REQUEST_CONFIRMATION", 'Success updating friend request confirmed status');
	define("FAILURE_IGNORING_FRIEND_REQUEST", 'Error ignoring friend request');
	define("SUCCESS_IGNORING_FRIEND_REQUEST", 'Success ignoring friend request');
	define("FAILURE_RETRIEVING_FRIENDS_LIST", 'Error retrieving friends list');
	define("SUCCESS_RETRIEVING_FRIENDS_LIST", 'Success retrieving friends list');
	define("FAILURE_RETRIEVING_PUZZLE_SOLUTION", 'Error retrieving puzzle solution');
	define("SUCCESS_RETRIEVING_PUZZLE_SOLUTION", 'Success retrieving puzzle solution');
	define("FAILURE_RETRIEVING_USER_DETAILS", 'Error retrieving user details');
	define("SUCCESS_RETRIEVING_USER_DETAILS", 'Success retrieving user details');
}

?>
