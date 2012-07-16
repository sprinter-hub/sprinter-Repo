<? php

require 'private/constants.php';

$binary = base64_decode($base);

$username = $_REQUEST['username'];

// binary, utf-8 bytes

header('Content-Type: image/jpg; charset=utf-8');
$filePath = PHOTOS_PATH . $username.'_img.jpg';

$file = fopen($filePath, 'wb');

fwrite($file, $binary);

fclose($file);

echo '<img src=' . $filePath . '>';
//11:57 PM add this before above code
  $base = $_REQUEST[COLUMN_AVATAR];



?>
