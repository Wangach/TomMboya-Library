<?php
include 'config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the order_id and status from the AJAX request
  $orderId = $_POST['order_id'];
  $status = $_POST['status'];

  // Update the order status in the database
  $update_query = "UPDATE `borrowedbooks` SET status='$status' WHERE order_id='$orderId'";
  
  if ($conn->query($update_query) === TRUE) {
    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'Invalid request.';
}
?>
