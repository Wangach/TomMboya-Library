<?php
include 'config.php';

$hunterApiKey = '0e78259b7ff926bbadf5f4ef1c17d1d2a64a59fd';
// Function to verify an email using the Hunter API
function verifyEmail($email, $hunterApiKey)
{
    $url = "https://api.hunter.io/v2/email-verifier?email=$email&api_key=$hunterApiKey";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if (isset($_POST['submit'])) {
    //mysqli_real_escape_string means to prevent sql injections
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['useremail']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phoneno']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Verify the email using the Hunter API
    $emailVerificationResult = verifyEmail($email, $hunterApiKey);

    if ($emailVerificationResult['data']['status'] === 'valid') {
        // Email is valid, proceed with registration
        $select = mysqli_query($conn, "SELECT * FROM `tommboyalibraryusers` WHERE Useremail ='$email'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $message[] = 'Email Address Already Exists 😕';
        } else {
            mysqli_query($conn, "INSERT INTO `tommboyalibraryusers` (username, Useremail, phoneno, password) VALUES('$name', '$email', $phonenumber, '$pass')") or die('query failed');
            $message[] = 'Registered Successfully ✔';
            header('location:login.php');
        }
    } else {
        $message[] = 'Invalid Email Address 😕';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="1tr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Tom Mboya Library</title>

    <!--Font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <!--Unicons link-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!---aos link stylesheet-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!--Awesome font kit-->
    <script src="https://kit.fontawesome.com/caea6e076b.js" crossorigin="anonymous"></script>

    <!--Custom CSS link-->
    <link rel="stylesheet" href="tml.css" />

</head>

<body>

    <section class="register">

        <div class="form-authorization">

            <form action="" method="post">
                <!--Logo-->
                <div class="registerlogo">
                    <a href="Tom Mboya Library.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
                </div>
                <h3>Welcome to Tom Mboya Library</h3>
                <h4>Register now to access resources.</h4>

                <div class="inputs">
                    <input type="text" name="username" required placeholder="Username" class="box">
                    <input type="email" name="useremail" required placeholder="Email address" class="box">
                    <input type="text" name="phoneno" required placeholder="Phone Number '2547 000 000'" class="box">
                    <input type="password" name="password" required placeholder="Password" class="box">
                    <input type="submit" name="submit" class="prim" value="Register">
                </div>

                <p>Already have an account? <a href="login.php">Login Now</a></p>

                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
                    }
                }
                ?>

            </form>

        </div>

    </section>


</body>

</html>