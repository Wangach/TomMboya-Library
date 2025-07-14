<?php
include 'config.php';


if (isset($_POST['mark_paid']) && isset($_POST['userlocation'])) {
    $order_id = $_POST['order_id'];
    $location = $_POST['userlocation']; // Retrieve the location value from the form

    // Store the location value in a variable for further use
    $locationValue = $_POST['userlocation'];

    // Update the status and location in the borrowedbooks table
    $updateQuery = "UPDATE borrowedbooks SET status = 'paid', userlocation = '$location' WHERE order_id = '$order_id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        // Status and location updated successfully

        // You can now use the $locationValue variable as needed
        echo "Location value: " . $locationValue;

        header('location: admindashboard.php'); // Redirect to your page
    } else {
        echo "Error updating status and location: " . $conn->error;
    }
} else {
    echo "User location not provided.";
}

?>
