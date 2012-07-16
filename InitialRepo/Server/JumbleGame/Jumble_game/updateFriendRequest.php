<?php
/*
 * @author prakash
 */
require 'funcs.php';

$conn = db_connect();

$user_id = 22;
$friend_id = 4;

$result = updateFriendRequest($conn, $user_id, $friend_id);

echo $result;

$conn = db_disconnect($conn);

?>