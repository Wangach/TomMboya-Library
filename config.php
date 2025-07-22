<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'admin123');
define('DB_NAME', 'tommboyalibrary');

//Mpesa credentials
define('CONSUMER_KEY', 'G8vaj6sEveWV7LPVACXnLKUhfAqJzPEpzbyTwoDP2wfkg2un');//You typically want to put this in a .env file
define('CONSUMER_SECRET', 'yMXQ6cGBr8SsLzeHjDDoJnr5QCPdGI4hVmoDSK3BX6wmAQvPIMAiGYjod0mNOZqQ');//You typically want to put this in a .env file
define('BUSINESS_SHORT_CODE', '174379');//You typically want to put this in a .env file
define('PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');//You typically want to put this in a .env file
define('CALLBACK_URL', 'https://ce30ccd2fb7f.ngrok-free.app/TomMboya-Library-2.0/donatecallback.php');
define('ACCOUNT_REFERENCE', 'Tom Mboya Library');
define('TRANSACTION_DESC', 'Lib Tests');
define('TRANSACTION_TYPE', 'CustomerPayBillOnline');
try {
  $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    echo "Connection failed";
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}