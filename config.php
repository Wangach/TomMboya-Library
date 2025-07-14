<?php

$conn = mysqli_connect('localhost','root','admin123','tommboyalibrary') or die('connection failed');

?>
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'admin123');
define('DB_NAME', 'tommboyalibrary');
try {
  $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    echo "Connection failed";
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}