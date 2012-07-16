<?php
/*
 * @author prakash
 */
require 'funcs.php';

$puzzles = array();

$conn = db_connect();

$username = 'six@mail.com';

$user_id = getUserId($conn, $username);

$result = getPuzzlesByUser($conn, $puzzles, $user_id);

echo $result;

$conn = db_disconnect($conn);

?>