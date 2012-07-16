<?php

require('SAM/php_sam.php');

//create a new connection object
$conn = new SAMConnection();

//start initialise the connection
$conn->connect(SAM_MQTT, array(SAM_HOST => 'www.indiansglobally.com',
                               SAM_PORT => 1883));      
//create a new MQTT message with the output of the shell command as the body
$msgCpu = new SAMMessage($_REQUEST['message']);
echo "tokudu\n";
$conn->send('topic://'.'tokudu/'.$_REQUEST['target'], $msgCpu);
         
$conn->disconnect();         

echo 'MQTT Message to ' . $_REQUEST['target'] . ' sent: ' . $_REQUEST['message']; 

?>
