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

if (isset($_POST['add_admin'])) {
    $adminname = mysqli_real_escape_string($conn, $_POST['adminname']);
    $nationalid = mysqli_real_escape_string($conn, $_POST['nationalid']);
    $adminemail = mysqli_real_escape_string($conn, $_POST['adminemail']);
    $adminphonenumber = mysqli_real_escape_string($conn, $_POST['adminphonenumber']);
    $adminpassword = mysqli_real_escape_string($conn, $_POST['adminpassword']);

    // Verify the admin's email using the Hunter API
    $emailVerificationResult = verifyEmail($adminemail, $hunterApiKey);

    if ($emailVerificationResult['data']['status'] === 'valid') {
        // Email is valid, proceed with admin addition

        // Check if the email already exists in the "admins" table
        $select = mysqli_query($conn, "SELECT * FROM `admins` WHERE adminemail ='$adminemail'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $message[] = 'Admin Email Address Already Exists 😕';
        } else {
            // Insert the new admin into the "admins" table
            mysqli_query($conn, "INSERT INTO `admins` (adminname, nationalid, adminemail, phonenumber, password) VALUES ('$adminname', '$nationalid', '$adminemail', '$adminphonenumber', '$adminpassword')") or die('query failed');
            $message[] = 'Admin Added Successfully ✔';
            // Redirect back to the admin page
            header('location:admindashboard.php');
        }
    } else {
        $message[] = 'Invalid Admin Email Address 😕';
    }
}

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
    }
}
?>
