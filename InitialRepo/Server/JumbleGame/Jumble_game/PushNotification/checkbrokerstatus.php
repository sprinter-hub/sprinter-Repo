<?php 
/*
 * file for checking wether the broker is running or not
 */


require('SAM/php_sam.php');

//create a new connection object

echo "in check broker ststus page \n";

$conn = new SAMConnection();

echo "conn establishing \n";

//start initialise the connection
$result = $conn->connect(SAM_MQTT, array(SAM_HOST => 'www.indiansglobally.com', SAM_PORT => 1883));      
if ($result) {
  $conn->disconnect();
  print_r("<span class='online'>Online</span>");
} else {
  print_r("<span class='offline'>Offline</span>");
}



?>
