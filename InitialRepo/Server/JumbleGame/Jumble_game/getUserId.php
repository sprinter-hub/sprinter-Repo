<?php

//phpinfo();

require 'facebook-php-sdk/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '392430827462486',
  'secret' => '392430827462486',
));

// Get User ID
$user = $facebook->getUser();

echo "user : " . $user . "<br />";

?>
