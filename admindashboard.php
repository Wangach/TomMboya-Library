<?php
include 'config.php';
session_start();

$admin_id = mysqli_real_escape_string($conn, $_SESSION['admin_id']);

// Check if user_id is not set, then redirect to login.php
if (!isset($_SESSION['admin_id'])) {
    header('location: adminlogin.php');
    exit; // Make sure to exit after the redirect to prevent further execution of the script
  }
if (isset($_GET['logout'])) {
    unset($admin_id);
    session_destroy();
    header('location:adminlogin.php');
}

// Function to get the count of books in a specific table
function getTableBookCount($conn, $tableName)
{
    $query = "SELECT COUNT(*) as count FROM $tableName";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

// Query to fetch users from tommboyalibraryusers table
$userQuery = "SELECT * FROM tommboyalibraryusers";
$userResult = $conn->query($userQuery);

$totalUsers = $userResult->num_rows; // Get the total number of users

// List of tables to count books from
$tables = ['romancebooks',  'horrorbooks', 'kidsbooks', 'trendingbooks', 'librarybooks'];

// Get the total number of books across all tables
$totalBooks = 0;
foreach ($tables as $table) {
    $totalBooks += getTableBookCount($conn, $table);
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
    <title>Admin Dashboard - Tom Mboya Library</title>

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
                <a href="admindashboard.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
            </div>
            <!--End of Logo-->


            <!--navbar-->
            <div class="navbar">
                <p>Administrator Dashboard</p>
            </div>
            <!--end of nabar-->

            <!--register & login-->
            <div class="nav-user">
                <!--User Profiles-->
                <div class="user-profile">

                    <?php
                    // Get name from database
                    $sql = "SELECT * FROM `admins` WHERE id='$admin_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            // Get first letter of name
                            $first_letter = substr($row["adminname"], 0, 1);
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
                        <a href="adminlogin.php" class="logoutprof" onclick="return confirm('Are you sure you want to logout?'); ">LOGOUT</a>
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

    <section class="showbooks">

        <div class="fixed-refresh-button" onclick="refreshPage()">
            <i class="fas fa-sync-alt"></i>
        </div>

        <div class="totalbooks">
            <!-- Display the total number of books and individual table counts -->
            <h3>Total Number of Books : <?php echo $totalBooks; ?></h3>
        </div>
        <div class="variousbooks">
            <ul>
                <?php foreach ($tables as $table) : ?>
                    <li><?php echo ucfirst($table) . " : " . getTableBookCount($conn, $table); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!--Show users-->
        <div class="userslist">
            <h3>Users (<?php echo $totalUsers; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                    if ($userResult->num_rows > 0) {
                        while ($userRow = $userResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $userRow['id'] . "</td>";
                            echo "<td>" . $userRow['username'] . "</td>";
                            echo "<td>" . $userRow['Useremail'] . "</td>";
                            echo "<td>" . $userRow['phoneno'] . "</td>";
                            echo "<td>";
                            echo "<form method='POST' action='delete_user.php'>";
                            echo "<input type='hidden' name='user_id' value='" . $userRow['id'] . "'>";
                            echo "<button type='submit' name='delete_user'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
                        <th>Payment</th> <!-- Add a new column for location input -->
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


        <!-- Add New User Form -->
        <div class="adduser">
            <div class="memberuser">
                <h4>Add New Delivery Staff</h4>
                <form method="POST" action="add_user.php">
                    <div class="inputfield">
                        <label for="adminname">Staff Name</label>
                        <input type="text" id="adminname" name="dname" placeholder="Staff Name" required>
                    </div>

                    <div class="inputfield">
                        <label for="nationalid">National ID</label>
                        <input type="text" id="nationalid" name="dnationalid" placeholder="National ID" required>
                    </div>

                    <div class="inputfield">
                        <label for="adminemail">Email</label>
                        <input type="email" id="adminemail" name="demail" placeholder="Staff Email" required>
                    </div>

                    <div class="inputfield">
                        <label for="adminphonenumber">Phone Number</label>
                        <input type="text" id="adminphonenumber" name="dphonenumber" placeholder="Phone Number" required>
                    </div>

                    <div class="inputfield">
                        <label for="adminpassword">Password</label>
                        <input type="password" id="adminpassword" name="dpassword" placeholder="Password" required>
                    </div>

                    <div class="addbutton">
                        <input type="submit" class="button" name="add_staff" value="Add Staff">
                    </div>
                </form>
            </div>

            <!-- Add New Admin Form -->
            <div class="adminuser">
                <h4>Add New Admin</h4>
                <form method="POST" action="add_admin.php">
                    <div class="inputfield">
                        <label for="adminname">Admin Name</label>
                        <input type="text" id="adminname" name="adminname" placeholder="Admin Name" required>
                    </div>

                    <div class="inputfield">
                        <label for="nationalid">National ID</label>
                        <input type="text" id="nationalid" name="nationalid" placeholder="National ID" required>
                    </div>

                    <div class="inputfield">
                        <label for="adminemail">Admin Email</label>
                        <input type="email" id="adminemail" name="adminemail" placeholder="Admin Email" required>
                    </div>

                    <div class="inputfield">
                        <label for="adminphonenumber">Phone Number</label>
                        <input type="text" id="adminphonenumber" name="adminphonenumber" placeholder="Phone Number" required>
                    </div>

                    <div class="inputfield">
                        <label for="adminpassword">Password</label>
                        <input type="password" id="adminpassword" name="adminpassword" placeholder="Password" required>
                    </div>

                    <div class="addbutton">
                        <input type="submit" class="button" name="add_admin" value="Add Admin">
                    </div>
                </form>
            </div>

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