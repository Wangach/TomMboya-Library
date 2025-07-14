<?php

include 'config.php';

// Get the order_id from the URL parameter
if (isset($_GET['order_id'])) {
  $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

  // Query the database to retrieve the phone number and price based on order_id
  $order_query = "SELECT phone_no, price FROM borrowedbooks WHERE order_id='$order_id'";
  $result = $conn->query($order_query);

  if ($result->num_rows > 0) {
      $order = $result->fetch_assoc();

      // Retrieve the phone number and price
      $PartyA = $order['phone_no'];
      $price = $order['price'];

      // Continue with your M-Pesa payment logic using $phone_number and $price
  } else {
      echo 'Order details not found.';
  }
} else {
  echo 'Order ID not provided.';
}

$consumerKey = 'DMX8bPISczshYOOUZH9LzrNhrA8wzNzc';
$consumerSecret = 'hnXKaMnIZ2FMmgpi';

$headers = ['Content-Type:application/json; charset=utf8'];

$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($result);
$access_token = $result->access_token;
/*echo $access_token;*/
curl_close($curl);

// Get the price and phone_no from the URL parameters



$initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$BusinessShortCode ='174379';
$Timestamp = date('YmdHis'); 
$PartyA = $PartyA; // This is your phone number, 
$CallBackURL = 'https://sparrow-accurate-dingo.ngrok-free.app/Tom%20Mboya%20Library/callback_url.php?order_id=' .$order_id; 
$AccountReference = $PartyA  . ' For Order No - ' .$order_id;
$TransactionDesc = 'Order No - ' ;
$Amount = $price;
$Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

$Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);


# header for stk push
$stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $initiate_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $price,
  'PartyA' => $PartyA,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' => $PartyA,
  'CallBackURL' => $CallBackURL,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
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
curl_close($curl);

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
    $response['message'] = "Payment successfully initialized.";
  }
}

// Send a JSON response
header("Content-Type: application/json");
echo json_encode($response);

?>