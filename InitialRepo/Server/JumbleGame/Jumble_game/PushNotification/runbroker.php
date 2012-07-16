<?php

echo "hi how r u \n";
$results = exec('ifconfig');
echo $results;

$results = exec('whoami');
echo $results;


?>
