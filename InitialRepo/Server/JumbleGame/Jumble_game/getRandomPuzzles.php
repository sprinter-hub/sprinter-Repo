<?php
/*
 * @author saitulasiram
 * @author prakash
 */
require 'private/funcs.php';

$conn = db_connect();

$username = "one@mail.com";

$uniquePuzzles = getRandomPuzzles($conn,$username);

db_disconnect($conn);

echo stripslashes(json_encode($uniquePuzzles));

?>
