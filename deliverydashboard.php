<?php
include 'config.php';
session_start();

$delivery_id = mysqli_real_escape_string($conn, $_SESSION['delivery_id']);

// Check if user_id is not set, then redirect to login.php
if (!isset($_SESSION['delivery_id'])) {
    header('location: deliverylogin.php');
    exit; // Make sure to exit after the redirect to prevent further execution of the script
  }
if (isset($_GET['logout'])) {
    unset($delivery_id);
    session_destroy();
    header('location:deliverylogin.php');
}


// Query to fetch unpaid borrowed books count
$unpaidOrdersCountQuery = "SELECT COUNT(*) as count FROM borrowedbooks WHERE status = 'unpaid'";
$unpaidOrdersCountResult = $conn->query($unpaidOrdersCountQuery);
$unpaidOrdersCount = 0;

if ($unpaidOrdersCountResult->num_rows > 0) {
    $row = $unpaidOrdersCountResult->fetch_assoc();
    $unpaidOrdersCount = $row['count'];
}


// Query to fetch the count of delivered orders
$deliveredOrdersCountQuery = "SELECT COUNT(*) as count FROM borrowedbooks WHERE status = 'delivered'";
$deliveredOrdersCountResult = $conn->query($deliveredOrdersCountQuery);
$deliveredOrdersCount = 0;

if ($deliveredOrdersCountResult->num_rows > 0) {
    $row = $deliveredOrdersCountResult->fetch_assoc();
    $deliveredOrdersCount = $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Delivery Staff Dashboard - Tom Mboya Library</title>

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
    <link rel="stylesheet" href="admin.css" />

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>

    <!---->
    <!--Header section starts here-->
    <header class="header">
        <div class="headflex">
            <!--Logo-->
            <div class="logo-card">
                <a href="deliverydashboard.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
            </div>
            <!--End of Logo-->


            <!--navbar-->
            <div class="navbar">
                <p>Delivery Staff Dashboard</p>
            </div>
            <!--end of nabar-->

            <!--register & login-->
            <div class="nav-user">
                <!--User Profiles-->
                <div class="user-profile">

                    <?php
                    // Get name from database
                    $sql = "SELECT * FROM `deliverystaff` WHERE id='$delivery_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            // Get first letter of name
                            $first_letter = substr($row["dname"], 0, 1);
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
                        <a href="deliverylogin.php" class="logoutprof" onclick="return confirm('Are you sure you want to logout?'); ">LOGOUT</a>
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

    <section class="showbooks del">

        <div class="fixed-refresh-button" onclick="refreshPage()">
            <i class="fas fa-sync-alt"></i>
        </div>


        <!-- Show orders -->
        <div class="borrowedbooks">
            <h3>Unpaid orders (<?php echo $unpaidOrdersCount; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Book Name</th>
                        <th>Borrower Name</th>
                        <th>Phone Number</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Address</th> 
                        <th>Payment</th><!-- Add a new column for location input -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch unpaid borrowed books
                    $borrowedBooksQuery = "SELECT * FROM borrowedbooks WHERE status = 'unpaid'";

                    $borrowedBooksResult = $conn->query($borrowedBooksQuery);

                    if ($borrowedBooksResult->num_rows > 0) {
                        while ($borrowedBooksRow = $borrowedBooksResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $borrowedBooksRow['order_id'] . "</td>";
                            echo "<td>" . $borrowedBooksRow['bookname'] . "</td>";
                            echo "<td>" . $borrowedBooksRow['borrower_name'] . "</td>";
                            echo "<td>" . $borrowedBooksRow['phone_no'] . "</td>";
                            echo "<td>" . $borrowedBooksRow['price'] . "</td>";
                            echo "<td>" . $borrowedBooksRow['status'] . "</td>";
                            echo "<td>" . $borrowedBooksRow['address'] . "</td>";
                            echo "<td>";
                            echo "<form method='POST' action='mark_paid.php'>";
                            // Add an input field for location
                            echo "<input type='text' name='userlocation' placeholder='Enter Location' required>";
                            echo "<input type='hidden' name='order_id' value='" . $borrowedBooksRow['order_id'] . "'>";
                            echo "<button type='submit' name='mark_paid'>Paid</button>";
                            echo "</form>";
                            echo "</tr>";
                            echo "</td>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No unpaid borrowed books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Show detailed order information -->
        <div class="currentorders">
            <h3>Delivered orders (<?php echo $deliveredOrdersCount; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Book Name</th>
                        <th>Phone Number</th>
                        <th>Borrower Name</th>
                        <th>Borrow Date</th>
                        <th>User Location</th>
                        <th>Duration (Days)</th>
                        <th>Action</th> <!-- Add a new column for the "Returned" button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch detailed order information with status = 'delivered'
                    $detailedOrdersQuery = "SELECT order_id, bookname, phone_no, borrower_name, borrow_date, userlocation, status FROM borrowedbooks WHERE status = 'delivered'";
                    $detailedOrdersResult = $conn->query($detailedOrdersQuery);

                    if ($detailedOrdersResult->num_rows > 0) {
                        while ($detailedOrdersRow = $detailedOrdersResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $detailedOrdersRow['order_id'] . "</td>";
                            echo "<td>" . $detailedOrdersRow['bookname'] . "</td>";
                            echo "<td>" . $detailedOrdersRow['phone_no'] . "</td>";
                            echo "<td>" . $detailedOrdersRow['borrower_name'] . "</td>";
                            echo "<td>" . $detailedOrdersRow['borrow_date'] . "</td>";
                            echo "<td>" . $detailedOrdersRow['userlocation'] . "</td>";

                            // Calculate duration (days)
                            $borrowDate = new DateTime($detailedOrdersRow['borrow_date']);
                            $currentDate = new DateTime();
                            $duration = $currentDate->diff($borrowDate)->days;

                            echo "<td>" . $duration . "</td>";

                            // Add a "Returned" button that updates the status
                            echo "<td>";
                            echo "<form method='POST' action='mark_returned.php'>";
                            echo "<input type='hidden' name='order_id' value='" . $detailedOrdersRow['order_id'] . "'>";
                            echo "<button type='submit' name='mark_returned'>Returned</button>";
                            echo "</form>";
                            echo "</td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No delivered orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>








    </section>


    <script>
        // JavaScript function to refresh the page
        function refreshPage() {
            location.reload();
        }
    </script>


</body>

</html>