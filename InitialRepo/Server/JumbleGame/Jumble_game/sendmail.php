<?php
$to = "knvarma37@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "saitulasiram@gmail.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?> 
