<?php
/*
 * @author prakash
 */
require 'funcs.php';

$conn = db_connect();

$puzzle_id = 2;
$user_id = 2;

$result = updatePuzzlePausedStatus($conn, $user_id, $puzzle_id);

echo $result;

$conn = db_disconnect($conn);

?>