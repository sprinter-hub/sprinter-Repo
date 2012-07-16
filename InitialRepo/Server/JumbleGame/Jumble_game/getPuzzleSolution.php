<?php
/*
 * @author prakash
 */
require 'funcs.php';

$conn = db_connect();

$puzzle_id = 6;

$result = getPuzzleSolution($conn, $puzzle_id);

echo $result;

$conn = db_disconnect($conn);

?>