<?php
/*
 * @author prakash
 */
require 'funcs.php';

$conn = db_connect();

$puzzle_id = 11;
$username = 'twentyOne@mail.com';
$friend_id = 26;
$max_time = 2;

$user_id = getUserId($conn, $username);

$result = sendPuzzleToFriend($conn, $puzzle_id, $username, $friend_id, $max_time);

echo $result;

$conn = db_disconnect($conn);

?>