<?php 

require 'funcs.php';
require 'constants/constants.php'

$conn = db_connect();

$username = $_REQUIRE[COLUMN_FB_ID];
$result = isFBUserExists($conn, );

echo $result;
$conn = db_disconnect($conn);

?>
