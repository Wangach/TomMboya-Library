<?php
include 'config.php';

if (isset($_POST['mark_returned']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update the status to "available" in the borrowedbooks table
    $updateBorrowedQuery = "UPDATE borrowedbooks SET status = 'available' WHERE order_id = '$order_id'";

    if ($conn->query($updateBorrowedQuery) === TRUE) {
        // Status updated successfully in the borrowedbooks table

        // Fetch the serialnumber from borrowedbooks
        $fetchSerialQuery = "SELECT serialnumber FROM borrowedbooks WHERE order_id = '$order_id'";
        $result = $conn->query($fetchSerialQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $serialnumber = $row['serialnumber'];

            // Update the availability to "available" in the librarybooks table using serialnumber
            $updateLibraryQuery = "UPDATE librarybooks SET availability = 'available' WHERE serialnumber = '$serialnumber'";

            if ($conn->query($updateLibraryQuery) === TRUE) {
                // Availability updated successfully in the librarybooks table
                header('location: admindashboard.php'); // Redirect back to the admin dashboard
            } else {
                echo "Error updating availability in librarybooks table: " . $conn->error;
            }
        } else {
            echo "Serial number not found for order ID: " . $order_id;
        }
    } else {
        echo "Error updating status in borrowedbooks table: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
