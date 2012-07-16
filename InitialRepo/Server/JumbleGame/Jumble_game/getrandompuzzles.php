<?php 

require "funcs.php";

$connect = db_connect();

getRandomPuzzles($connect);

db_disconnect($connect);

//echo  $randompuzzles;
?>