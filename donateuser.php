<?php
include 'config.php';
session_start();

$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

// Check if user_id is not set, then redirect to login.php
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit; // Make sure to exit after the redirect to prevent further execution of the script
}
if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Donate - Tom Mboya Library</title>

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
    <link rel="stylesheet" href="brow.css" />

    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<!--Beginning of body-->

<body>


    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="messageborrow" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>

    <!---->
    <!--Header section starts here-->
    <header class="header">
        <div class="headflex">
            <!--Logo-->
            <div class="logo-card">
                <a href="indexuser.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
            </div>
            <!--End of Logo-->


            <!--navbar-->
            <div class="navbar">
                <div id="nav-close" class="fas fa-times"></div>
                <a href="indexusers.php#services">services</a>
                <a href="browseuser.php">browse</a>
                <a href="borrowuser.php">borrow</a>
                <a href="donateuser.php">donate</a>
                <a href="aboutuser.php">About Us</a>
            </div>
            <!--end of nabar-->

            <!--register & login-->
            <div class="nav-user">
                <!--User Profiles-->
                <div class="user-profile">

                    <?php
                    // Get name from database
                    $sql = "SELECT * FROM `tommboyalibraryusers` WHERE id='$user_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            // Get first letter of name
                            $first_letter = substr($row["username"], 0, 1);
                            // Display first letter in circle
                        }
                    } else {
                        $message[] = 'Email account does not exist ❌';
                    };
                    ?>

                    <div class="profiles">
                        <div class="profcircle">
                            <p>
                                <?php
                                echo $first_letter;
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="profiles">
                        <a href="index.php" class="logoutprof" onclick="return confirm('Are you sure you want to logout?'); ">LOGOUT</a>
                    </div>

                </div>
                <!--End of User Profiles-->
            </div>
            <!--end of register & login-->

            <!--Responsive menu button-->
            <div class="icons">
                <div id="menu-btn"><i class="fas fa-bars"></i></div>

            </div>
            <!--end of responsive menu button-->

        </div>
    </header>
    <!--Header section ends here-->

    <section class="donate-money">
        <div class="donatediv">

            <h5>Add a smile to someone's world</h5>
            <form id="donate-form" method="post" action="donatepayment.php">
                <div class="inputfield">
                    <label for="donorphonenumber">Phone Number </label>
                    <input type="text" id="donorphonenumber" name="donorphonenumber" placeholder="254" required>
                </div>
                <div class="inputfield">
                    <label for="donoramount">Amount </label>
                    <input type="text" id="donoramount" name="donoramount" placeholder="" required>
                </div>
                <div class="donate-button">
                    <button id="donate-now" class="prim">Donate Now</button>
                </div>
            </form>
            <div id="payment-response"></div>
            <div id="payment-warning"></div>
        </div>
    </section>

    <section class="donate-text">
        <h5>Share the gift of knowledge</h5>
        <p>At Tom Mboya Library, we believe that every book has the power to spark joy, curiosity and lifelong learning. With your generous support, you have the incredible opportunity to add a smile to someone's world.</p>
        <h5 class="donate-intro">Why Your Donations Matter</h5>
        <p>1. Enabling Access: Your donations help us acquire new books, e-books and educational resources, ensuring that our library remains a vibrant hub for knowledge and discovery. When you give, you open doors to worlds of imagination and knowledge for our community.</p>
        <p>2. Fostering Literacy: Many individuals in our community may not have the means to access books and resources independently. Your contributions help us provide opportunities for reading and literacy, creating a brighter future for all.</p>
        <p>3. Building Community: A thriving library is a cornerstone of a vibrant community. By contributing, you strengthen our library's ability to host events, workshops and programs that bring people together and enrich lives.</p>
        <p>4. Empowering Dreams: Every book you donate represents an opportunity for someone to learn, dream and grow. Your support empowers individuals to pursue their passions and fulfill their potential.</p>
        <h5 class="donate-intro">Make Your Donation Today</h5>
        <p>Making a donation is as easy as visiting our library in person or donating online through our website. Your generosity is a beacon of hope for those who will benefit from the knowledge and inspiration found within the pages of our books.</p>
        <p>With your help, we can continue to brighten lives, one book at a time. Thank you for sharing the gift of knowledge and making our library a place where smiles and dreams flourish.</p>
    </section>

    <!---->
    <footer class="tml">

        <div class="tmlfoot">

            <div class="tmlabout">
                <h2><span>T</span>om Mboya Library</h2>
                <p>Tom Mboya Library is located in Kisumu, Kenya. The library’s mission is to provide better digitized access to reading materials. It has a collection of more than thirteen thousand processed books that are currently being utilized by the patrons.</p>
            </div>

            <div class="tmltext">
                <div class="tmlquote">
                    <p class="thequote">"This Library is so perfect. It’s got something of everything"</p>
                    <p class="quoter">Bill Bryson</p>
                </div>
                <div class="socials">
                    <li><a href="https://wa.me/+254769635821?text=Hello20%Tom20%Mboya20%Library"><i class="fa fa-whatsapp"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                </div>

            </div>

        </div>

        <div class="footlinks">

            <div class="locs">
                <p><a href="https://goo.gl/maps/DSBBgmdtaGRK9DGZ7">Tom Mboya Estate, Kisumu</a></p>
                <p><a href="tel: +254769635821">+254 000 254 000</a></p>
                <p><a href="mailto:fredkush6@gmail.com">tommboyalibrary@gmail.com </a></p>
            </div>

            <div class="thelinks">
                <a href="indexusers.php#services">Services</a>
                <a href="browseuser.php">Browse</a>
                <a href="borrowuser.php">Borrow</a>
                <a href="donateuser.php">Donate</a>
                <a href="aboutuser.php#opening">Opening Hours</a>
                <a href="about.php">About</a>
                <a href="login.php" onclick="return confirm('Are you sure you want to logout?'); ">LogOut</a>
            </div>>

        </div>

        <div class="copyright">
            <p>© 2023 Tom Mboya Library. All rights reserved.</p>
        </div>

    </footer>
    <!--End of Footer-->


    <!---->
    <!--Custom javascript file link-->
    <script src="JS FILES/tml.js"></script>

    <script>
        $(document).ready(function() {
            // Function to disable the "Pay Now" button and change cursor style
            function disablePayButton() {
                $('#donate-now').prop('disabled', true);
                $('#donate-now').css('cursor', 'not-allowed');
                $('#donate-now').html('Please wait...');
            }

            // Function to enable the "Pay Now" button and restore cursor style
            function enablePayButton() {
                $('#donate-now').prop('disabled', false);
                $('#donate-now').css('cursor', 'pointer');
                $('#donate-now').html('Donate Now');
            }

            function showMpesaResponse() {
                document.querySelector('#payment-response').style.display = 'block';
            }

            function showMpesaWarning() {
                document.querySelector('#payment-warning').style.display = 'block';
                document.querySelector('#payment-response').style.display = 'none';
            }
            // Handle form submission when the "Pay Now" button is clicked
            $('#donate-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Disable the "Pay Now" button and change cursor style
                disablePayButton();


                // Serialize the form data
                var formData = $(this).serialize();

                // Send an AJAX POST request to mpesa_payment.php
                $.ajax({
                    type: 'POST',
                    url: 'donatepayment.php',
                    data: formData,
                    success: function(response) {
                        // Handle the response here
                        if (response.success) {
                            showMpesaResponse();
                            $('#payment-response').html('Payment successfully initialized.');
                        } else {
                            showMpesaWarning();
                            $('#payment-warning').html(response.message);
                        }
                        // Enable the "Pay Now" button and restore cursor style
                        enablePayButton();
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX request errors
                        $('#payment-warning').html(error);
                    }
                });
            });
        });
    </script>
</body>

</html>