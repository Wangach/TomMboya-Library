<?php
include 'config.php';

header("Content-Type: application/json");
$stkCallbackResponse = file_get_contents('php://input');
// $logFile = "Mpesastkresponse.json";
// $log = fopen($logFile, "a");
// fwrite($log, $stkCallbackResponse);
// fclose($log);

$data = json_decode($stkCallbackResponse);

$MerchantRequestID = $data->Body->stkCallback->MerchantRequestID;
$CheckoutRequestID = $data->Body->stkCallback->CheckoutRequestID;
$ResultCode = $data->Body->stkCallback->ResultCode;
$ResultDesc = $data->Body->stkCallback->ResultDesc;
$Amount = $data->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$TransactionId = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$UserPhoneNumber = $data->Body->stkCallback->CallbackMetadata->Item[4]->Value;

// Retrieve the order_id from the URL parameter
if (isset($_GET['order_id'])) {
  $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);  
  // CHECK IF THE TRANSACTION WAS SUCCESSFUL 
  if ($ResultCode == 0) {
    // Insert the data into the payments table along with the order_id
    $insertQuery = "INSERT INTO `payments` (orderid, MerchantRequestID, CheckoutRequestID, ResultCode, amount, MpesaReceiptNumber, phonenumber) VALUES ('$order_id','$MerchantRequestID','$CheckoutRequestID', '$ResultCode','$Amount', '$TransactionId','$UserPhoneNumber')";

    if (mysqli_query($conn, $insertQuery)) {
      // Data inserted successfully
      echo "Data inserted successfully";

      // Update the status as paid in the borrowedbooks table
      $updateQuery = "UPDATE `borrowedbooks` SET status = 'paid' WHERE order_id = '$order_id'";

      if (mysqli_query($conn, $updateQuery)) {
        echo "Status updated as paid.";
      } else {
        // Handle the error
        echo "Error updating status: " . mysqli_error($conn);
      }
    } else {
      // Handle the error
      unset($logFile);
    }
  } else {
    echo "Error: " . mysqli_error($conn);
  }
} else {
  echo 'Order ID not provided in the callback URL.';
}
?>