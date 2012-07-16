<?php


$host="guesstheword.db.5679346.hostedresource.com"; // Host name
$username="guesstheword"; // Mysql username
$password="Guess123"; // Mysql password
$db_name="guesstheword"; // Database name


//Connect to server and select database.
mysql_connect("guesstheword.db.5679346.hostedresource.com", "guesstheword", "Guess123")or die("cannot connect to server");
mysql_select_db("guesstheword")or die("cannot select DB");

?>
