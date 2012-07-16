<?php
/*
 * @author prakash
 */
require 'funcs.php';

$conn = db_connect();

$puzzle_id = 11;
$user_id = 26;

$result = updatePuzzleAnsweredStatus($conn, $user_id, $puzzle_id);

echo $result;

$conn = db_disconnect($conn);

?>