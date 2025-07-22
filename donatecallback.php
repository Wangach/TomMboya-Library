<?php
include 'config.php';

// include 'dbconnection.php';
header("Content-Type: application/json");
$stkCallbackResponse = file_get_contents('php://input');
// $logFile = "Mpesastkresponse.json";

// $logDir = __DIR__; // Ensure file is written in the same directory as the script
// if (!is_writable($logDir)) {
//     error_log("Directory $logDir is not writable");
//     http_response_code(500);
//     echo json_encode(["error" => "Server error: Cannot write to log directory"]);
//     exit;
// }
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

echo $ResultCode;
//CHECK IF THE TRASACTION WAS SUCCESSFUL 
// if ($ResultCode == 0) {
//   //STORE THE TRANSACTION DETAILS IN THE DATABASE
//   mysqli_query($conn, "INSERT INTO `donations` (phonenumber, MerchantRequestID, CheckoutRequestID, amount, MpesaReceiptNumber) VALUES ('$UserPhoneNumber', '$MerchantRequestID', '$CheckoutRequestID', '$Amount', '$TransactionId')");
// }
// Enable error reporting for debugging (disable in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// header("Content-Type: application/json");
// $DonationstkResponse = file_get_contents('php://input');
// $logFile = "donations.json";

// $logDir = __DIR__; // Ensure file is written in the same directory as the script
// if (!is_writable($logDir)) {
//     error_log("Directory $logDir is not writable");
//     http_response_code(500);
//     echo json_encode(["error" => "Server error: Cannot write to log directory"]);
//     exit;
// }

// $log = fopen($logFile, "a");
// if ($log === false) {
//     error_log("Failed to open $logFile for writing");
//     http_response_code(500);
//     echo json_encode(["error" => "Server error: Cannot write to log file"]);
//     exit;
// }
// fwrite($log, $DonationstkResponse . "\n"); // Add newline for readability
// fclose($log);


// // CHECK IF THE TRANSACTION WAS SUCCESSFUL 
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