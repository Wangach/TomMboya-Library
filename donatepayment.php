<?php
include 'accessToken.php';

$donorphonenumber = mysqli_real_escape_string($conn, $_POST['donorphonenumber']);
$donoramount = mysqli_real_escape_string($conn, $_POST['donoramount']);

$headers = ['Content-Type:application/json; charset=utf8'];

$initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$Timestamp = date('YmdHis'); 
$PartyA = $donorphonenumber; // This is your phone number, 
$Amount = $donoramount;

$Password = base64_encode(BUSINESS_SHORT_CODE.PASSKEY.$Timestamp);


# header for stk push
$stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $initiate_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => BUSINESS_SHORT_CODE,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => TRANSACTION_TYPE,
  'Amount' => $donoramount,
  'PartyA' => $donorphonenumber,
  'PartyB' => BUSINESS_SHORT_CODE,
  'PhoneNumber' => $donorphonenumber,
  'CallBackURL' => CALLBACK_URL,
  'AccountReference' => ACCOUNT_REFERENCE,
  'TransactionDesc' => TRANSACTION_DESC
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
/*
print_r($curl_response);
echo $curl_response;
*/
// Close the cURL session
// curl_close($curl);

$response = array();

if (strpos($curl_response, 'Unauthorized') !== false) {
  // Unauthorized request, handle the error
  $response['success'] = false;
  $response['message'] = "Unauthorized request to Safaricom API.";
} else {
  // Check if the response is empty or contains an error
  $response_data = json_decode($curl_response);
  if (empty($response_data) || isset($response_data->errorMessage)) {
    // Payment request failed
    $response['success'] = false;
    $response['message'] = "Payment request failed:" . ($response_data->errorMessage ?? 'Unknown error');
  } else {
    // Payment request successful
    $response['success'] = true;
    $response['message'] = "Payment successfully initialized...";
  }
}

// Send a JSON response
header("Content-Type: application/json");
echo json_encode($response);

?>