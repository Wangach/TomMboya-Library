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

// Check if order_id is provided in the query parameter
if (isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

    // Query to fetch order details from borrowedbooks table
    $order_query = "SELECT * FROM borrowedbooks WHERE order_id='$order_id'";
    $result = $conn->query($order_query);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // Fetch additional book details from librarybooks table using serialnumber and bookname
        $serialnumber = $order['serialnumber'];
        $bookname = $order['bookname'];
        $phoneno = $order['phone_no'];


        $book_query = "SELECT * FROM librarybooks WHERE serialnumber='$serialnumber' AND bookname='$bookname'";
        $book_result = $conn->query($book_query);

        if ($book_result->num_rows > 0) {
            $book_details = $book_result->fetch_assoc();

            // Display book details for payment
            // You can use these details to create a payment form
            $image = $book_details['image'];
            $author = $book_details['author'];
            $description = $book_details['description'];
            $price = $book_details['price'];
        } else {
            $message[] = 'Book details not found.';
        }
    } else {
        $message[] = 'Order not found.';
    }
} else {
    $message[] = 'Order ID not provided.';
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Make order - Tom Mboya Library</title>

    <!-- Font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <!-- Unicons link -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- AOS link stylesheet -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Awesome font kit -->
    <script src="https://kit.fontawesome.com/caea6e076b.js" crossorigin="anonymous"></script>

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="tml.css" />
    <link rel="stylesheet" href="brow.css" />

    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="messageborrow" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>

    <!---->
    <!-- Header section starts here -->
    <header class="header">
        <div class="headflex">
            <!-- Logo -->
            <div class="logo-card">
                <a href="indexusers.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
            </div>
            <!-- End of Logo -->

            <!-- Navbar -->
            <div class="navbar">
                <div id="nav-close" class="fas fa-times"></div>
                <a href="indexusers.php#services">services</a>
                <a href="browseuser.php">browse</a>
                <a href="borrowuser.php">borrow</a>
                <a href="donateuser.php">donate</a>
                <a href="aboutuser.php">About Us</a>
            </div>
            <!-- End of Navbar -->

            <!-- Register & Login -->
            <div class="nav-user">
                <!-- User Profiles -->
                <div class="user-profile">
                    <?php
                    // Get name from database
                    $sql = "SELECT * FROM `tommboyalibraryusers` WHERE id='$user_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            // Get first letter of name
                            $first_letter = isset($row["username"]) ? substr($row["username"], 0, 1) : ''; // Check if username exists
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
                                if (isset($first_letter)) {
                                    echo $first_letter;
                                }
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="profiles">
                        <a href="index.php" class="logoutprof" onclick="return confirm('Are you sure you want to logout?'); ">LOGOUT</a>
                    </div>
                </div>
                <!-- End of User Profiles -->
            </div>
            <!-- End of Register & Login -->

            <!-- Responsive menu button -->
            <div class="icons">
                <div id="menu-btn"><i class="fas fa-bars"></i></div>
            </div>
            <!-- End of responsive menu button -->
        </div>
    </header>
    <!-- Header section ends here -->

    <!-- Book Details and Payment Form -->
    <section class="book-details">
        <h3>Confirm order details</h3>
        <div class="book-info">
            <div class="book-imagedesc">
                <div class="book-image">
                    <img src="tomimages/background/<?php echo $image; ?>" alt="Book Image">
                </div>
                <div class="book-text">
                    <div class="book-title">
                        <h4><?php echo $bookname; ?></h4>
                        <p>By <?php echo $author; ?></p>
                    </div>
                    <p><?php echo $description; ?></p>
                    <p class="bprice"> KSH <?php echo $price; ?></p>
                    <!-- Add an address input form -->
                    <?php
                    // Display update status message for additional details
                    if (isset($_POST['submitAddress'])) {
                        $address = mysqli_real_escape_string($conn, $_POST['address']);
                        $additionalDetails = mysqli_real_escape_string($conn, $_POST['additionalDetails']);
                        $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);

                        // Update the "address" and "additionaldetails" columns in the "borrowedbooks" table for the respective "order_id"
                        $update_query = "UPDATE borrowedbooks SET address='$address', additionaldetails='$additionalDetails', phone_no='$phonenumber' WHERE order_id='$order_id'";
                        if ($conn->query($update_query) === TRUE) {
                            echo '<div class="messageborrow" onclick="this.remove();">Address and additional details added</div>';
                        } else {
                            echo '<div class="messageborrow" onclick="this.remove();">Error adding address and additional details: ' . $conn->error . '</div>';
                        }
                        $amount = $price; // Assuming $price holds the book price
                    }
                    ?>
                    <div class="add-address">
                        <h5>Add your address to proceed to payment</h5>
                        <form class="addressform" method="post">
                            <div class="inputform">
                                <input type="text" name="address" placeholder="Enter your address" required>
                            </div>
                            <div class="textform">
                                <textarea name="additionalDetails" rows="1" cols="40" placeholder="Additional Details(Optional)"></textarea>
                            </div>
                            <div class="numberform">
                                <input type="text" name="phonenumber" placeholder="Mpesa No e.g '254700000000'" required>
                            </div>
                            <div class="formbutton">
                                <button class="prim" type="submit" name="submitAddress">Submit</button>
                            </div>
                        </form>
                    </div>

                    <!--div class for mpesa payment-->
                    <div class="mpesadiv">
                        <h5>Pay with M-Pesa</h5>
                        <p class="amounttopay">Amount to pay: KSH <?php echo $price; ?></p>
                        <form id="mpesa-payment-form" method="post" action="mpesa_payment.php?order_id=<?php echo $order_id; ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <input type="hidden" name="amount" value="<?php echo $price; ?>">
                            <input type="hidden" name="phoneno" value="<?php echo $phoneno; ?>">
                            <button id="pay" class="prim">Pay Now</button>
                        </form>
                        <div id="payment-response"></div>
                        <div id="payment-warning"></div>
                    </div>



                </div>
            </div>



    </section>



    <script>
        // Function to hide the "add-address" div and show the "mpesadiv" div
        function showMpesaDiv() {
            document.querySelector('.add-address').style.display = 'none';
            document.querySelector('.mpesadiv').style.display = 'block';
        }

        // Check if the "address" and "additionalDetails" are not empty (added successfully)
        <?php
        if (isset($_POST['submitAddress'])) {
            echo 'showMpesaDiv();';
        }
        ?>
    </script>

    <script>
        $(document).ready(function() {
            // Function to disable the "Pay Now" button and change cursor style
            function disablePayButton() {
                $('#pay').prop('disabled', true);
                $('#pay').css('cursor', 'not-allowed');
                $('#pay').html('Please wait...');
            }

            // Function to enable the "Pay Now" button and restore cursor style
            function enablePayButton() {
                $('#pay').prop('disabled', false);
                $('#pay').css('cursor', 'pointer');
                $('#pay').html('Pay Now');
            }

            function showMpesaResponse() {
                document.querySelector('#payment-response').style.display = 'block';
            }
            function showMpesaWarning() {
                document.querySelector('#payment-warning').style.display = 'block';
                document.querySelector('#payment-response').style.display = 'none';
            }
            // Handle form submission when the "Pay Now" button is clicked
            $('#mpesa-payment-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Disable the "Pay Now" button and change cursor style
                disablePayButton();
                

                // Serialize the form data
                var formData = $(this).serialize();

                // Send an AJAX POST request to mpesa_payment.php
                $.ajax({
                    type: 'POST',
                    url: 'mpesa_payment.php?order_id=<?php echo $order_id; ?>',
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