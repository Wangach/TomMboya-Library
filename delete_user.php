<?php
include 'config.php';

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Perform the user deletion
    $deleteQuery = "DELETE FROM tommboyalibraryusers WHERE id = $user_id";
    if ($conn->query($deleteQuery) === TRUE) {
        header('location:admindashboard.php'); // Redirect to your page
        // You can redirect back to the user list page or perform any other action here.
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
