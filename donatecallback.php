<?php
include 'config.php';

header("Content-Type: application/json");
$DonationstkResponse = file_get_contents('php://input');
$logFile = "donations.json";
$log = fopen($logFile, "a");
fwrite($log, $DonationstkResponse);
fclose($log);

$data = json_decode($DonationstkResponse);

$MerchantRequestID = $data->Body->stkCallback->MerchantRequestID;
$CheckoutRequestID = $data->Body->stkCallback->CheckoutRequestID;
$ResultCode = $data->Body->stkCallback->ResultCode;
$ResultDesc = $data->Body->stkCallback->ResultDesc;
$Amount = $data->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$TransactionId = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$UserPhoneNumber = $data->Body->stkCallback->CallbackMetadata->Item[4]->Value;

// CHECK IF THE TRANSACTION WAS SUCCESSFUL 
if ($ResultCode == 0) {
    // Insert the data into the payments table along with the order_id
    $insertQuery = "INSERT INTO `donations` (phonenumber, MerchantRequestID, CheckoutRequestID, amount, MpesaReceiptNumber) VALUES ('$UserPhoneNumber', '$MerchantRequestID', '$CheckoutRequestID', '$Amount', '$TransactionId')";

    if (mysqli_query($conn, $insertQuery)) {
        // Data inserted successfully
        echo "Data inserted successfully";
    } else {
        // Handle the error
        unset($logFile);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>