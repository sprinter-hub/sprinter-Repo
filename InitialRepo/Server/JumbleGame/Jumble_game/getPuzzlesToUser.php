<?php
/*
 * @author prakash
 */
require 'funcs.php';

$puzzles = array();

$conn = db_connect();

$username = 'twentyOne@mail.com';

$user_id = getUserId($conn, $username);
$result = getPuzzlesToUser($conn, $puzzles, $user_id);

echo $result;

$conn = db_disconnect($conn);

?>