<?php
include 'config.php';

$hunterApiKey = '0e78259b7ff926bbadf5f4ef1c17d1d2a64a59fd';

function verifyEmail($email, $hunterApiKey) {
    $url = "https://api.hunter.io/v2/email-verifier?email=$email&api_key=$hunterApiKey";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if (isset($_POST['add_staff'])) {
    $dname = mysqli_real_escape_string($conn, $_POST['dname']);
    $dnationalid = mysqli_real_escape_string($conn, $_POST['dnationalid']);
    $demail = mysqli_real_escape_string($conn, $_POST['demail']);
    $dphonenumber = mysqli_real_escape_string($conn, $_POST['dphonenumber']);
    $dpassword = mysqli_real_escape_string($conn, $_POST['dpassword']);

    // Verify the admin's email using the Hunter API
    $emailVerificationResult = verifyEmail($demail, $hunterApiKey);

    if ($emailVerificationResult['data']['status'] === 'valid') {
        // Email is valid, proceed with admin addition

        // Check if the email already exists in the "admins" table
        $select = mysqli_query($conn, "SELECT * FROM `deliverystaff` WHERE demail ='$demail'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $message = "Staff email already exists";
            header("Location: admindashboard.php?message=" . urlencode($message));
        } else {
            // Insert the new admin into the "admins" table
            mysqli_query($conn, "INSERT INTO `deliverystaff` (dname, dnationalid, dphonenumber, demail, dpassword) VALUES ('$dname', '$dnationalid', '$dphonenumber', '$demail', '$dpassword')") or die('query failed');
            $message = "Staff details addes successfully";
            header("Location: admindashboard.php?message=" . urlencode($message));
        }
    } else {
        $message = "Invalid Staff Email";
        header("Location: admindashboard.php?message=" . urlencode($message));
    }
}

?>
