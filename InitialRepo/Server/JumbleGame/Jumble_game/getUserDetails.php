<?php
/*
 * @author prakash
 */
require 'funcs.php';

$conn = db_connect();

$puzzle_id = 5;
$user_id = 22;

$result = getUserDetails($conn, $user_id);

echo $result;

$conn = db_disconnect($conn);

?>