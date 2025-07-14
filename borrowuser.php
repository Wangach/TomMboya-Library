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

// Check if the "Order" button is clicked
if (isset($_POST['order'])) {
  // Get book details from the form
  $serialnumber = $_POST['serialnumber'];
  $bookname = $_POST['bookname'];
  $price = $_POST['price'];

  // Get user details
  $sql = "SELECT * FROM `tommboyalibraryusers` WHERE id='$user_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Fetch user details
    $user = $result->fetch_assoc();
    $borrower_id = $user['id'];
    $phone_no = $user['phoneno'];
    $borrower_name = $user['username'];

    // Get the current date
    $borrow_Date = date("Y-m-d");

    // Add other fields like price here


    // Insert the order into the borrowedbooks table
    $insert_query = "INSERT INTO `borrowedbooks` (serialnumber, bookname, borrower_id, phone_no, borrower_name, borrow_date, price, status, userlocation) VALUES ('$serialnumber', '$bookname', '$borrower_id', '$phone_no', '$borrower_name', '$borrow_Date', '$price', 'unpaid', 'none')";
    if ($conn->query($insert_query) === TRUE) {
      // Update the availability in the librarybooks table as "borrowed"
      $update_query = "UPDATE `librarybooks` SET availability='unaivalable' WHERE serialnumber='$serialnumber'";
      if ($conn->query($update_query) === TRUE) {
        // Order successful
        $message[] = 'Order placed successfully!';
      } else {
        $message[] = 'Failed to update book availability.';
      }
    } else {
      $message[] = 'Failed to place the order.';
    }
  } else {
    $message[] = 'User not found.';
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Borrow - Tom Mboya Library</title>

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
        <a href="indexusers.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
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


  <!--Sidebar-->
  <section class="sidebar">
    <div class="showorders">
      <h4>Orders</h4>
      <h5>NB: Delivery services are only available within a 5-kilometer radius of the library.</h5>
      <?php
      // Query the borrowedbooks table to fetch order_id and bookname for the logged-in user
      $order_query = "SELECT order_id, bookname, status FROM borrowedbooks WHERE borrower_id='$user_id'";
      $result = $conn->query($order_query);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if ($row['status'] !== 'available') {
            echo '<div class="ordersec">';
            echo '<div class="order-item">';
            echo '<p class="orderno">' . $row['order_id'] . '. </p>';
            echo '<p class="ordername">' . $row['bookname'] . '</p>';
            echo '</div>';
            echo '<div class="orderstatus">';
            echo '<p class="status">' . $row['status'] . '</p>';

            // Check if the order status is "unpaid" and display Pay button
            if ($row['status'] === 'unpaid') {
              echo '<a class="pay-button" href="makeorder.php?order_id=' . $row['order_id'] . '">Pay</a>';
            }
            // Inside the loop that displays orders in the sidebar
            if ($row['status'] === 'paid') {
              echo '<button class="delivered-button" data-order-id="' . $row['order_id'] . '">Delivered</button>';
            }

            echo '</div>';
            echo '</div>';
          }
        }
      } else {
        echo 'No orders yet.';
      }
      ?>
    </div>
  </section>

  <!--end of sidebar-->

  <!--sec-->
  <section class="lib-books content">
    <div class="bookcontentdiv">
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search...">
        <button id="searchButton">Search</button>
      </div>

      <h3>Library books</h3>

      <!-- Add a div to display search results -->
      <div class="search-results">
        <!-- Search results will be displayed here -->
      </div>

      <div class="booklist">
        <div class="eachbook-box">
          <?php
          $select_librarybook = mysqli_query($conn, "SELECT * FROM `librarybooks`") or die('query failed');
          if (mysqli_num_rows($select_librarybook) > 0) {
            while ($fetch_librarybook = mysqli_fetch_assoc($select_librarybook)) {
              // Retrieve the serial number for each book
              $serialnumber = $fetch_librarybook['serialnumber'];

          ?>

              <form method="post" class="bookcontentsec" action="">
                <input type="hidden" name="serialnumber" value="<?php echo $serialnumber; ?>">
                <input type="hidden" name="bookname" value="<?php echo $fetch_librarybook['bookname']; ?>">
                <input type="hidden" name="price" value="<?php echo $fetch_librarybook['price']; ?>">

                <div class="book-imagesec">
                  <img class="bookimage" src="tomimages/background/<?php echo $fetch_librarybook['image']; ?>" alt="">
                </div>

                <div class="bookcontent">
                  <div class="book-namedet">
                    <div class="libname"><?php echo $fetch_librarybook['bookname']; ?></div>
                    <div class="bookauthor">By <?php echo $fetch_librarybook['author']; ?></div>
                  </div>

                  <div class="bookdescription"><?php echo $fetch_librarybook['description']; ?></div>

                  <div class="priceav">
                    <div class="bookpricey">KSH <?php echo $fetch_librarybook['price']; ?> for 14 days</div>
                    <div class="bookavailability"><?php echo $fetch_librarybook['availability']; ?></div>
                  </div>

                  <div class="booknumber"><?php echo $serialnumber; ?></div>

                  <div class="orderbutton">
                    <?php if ($fetch_librarybook['availability'] === 'available') : ?>
                      <button class="prim" type="submit" name="order">Order</button>
                    <?php else : ?>
                      <button class="nodrop" type="button" disabled>Unavailable</button>
                      <p class="unavailable-msg">This book is currently unavailable for order.</p>
                    <?php endif; ?>
                  </div>

                </div>
              </form>



          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </section>
  <!--end of sec-->


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
    document.addEventListener("DOMContentLoaded", function() {
      const searchInput = document.getElementById("searchInput");
      const searchButton = document.getElementById("searchButton");
      const bookContainers = document.querySelectorAll(".bookcontentsec");
      const searchResults = document.querySelector(".search-results");
      const booklist = document.querySelector(".booklist");

      searchButton.addEventListener("click", function() {
        searchBooks();
      });

      // Function to search and display books
      function searchBooks() {
        const searchQuery = searchInput.value.trim().toLowerCase();

        // Clear existing search results and hide booklist
        searchResults.innerHTML = "";
        booklist.style.display = "none";

        bookContainers.forEach(function(container) {
          const bookName = container.querySelector(".libname").textContent.toLowerCase();

          if (bookName.includes(searchQuery)) {
            // Clone the matching book container and append it to search results
            const clone = container.cloneNode(true);
            searchResults.appendChild(clone);
          }
        });

        // If search input is empty, display all books and show booklist
        if (searchQuery === "") {
          booklist.style.display = "block";
        }
      }

      // Call the searchBooks function on input change (when search bar is cleared)
      searchInput.addEventListener("input", function() {
        searchBooks();
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".delivered-button").click(function() {
        var orderId = $(this).data("order-id");
        var buttonElement = $(this); // Store the button element in a variable

        // Send an AJAX request to update the status to "delivered"
        $.ajax({
          url: 'update_status.php',
          method: 'POST',
          data: {
            order_id: orderId,
            status: 'delivered'
          },
          success: function(response) {
            if (response === 'success') {
              // Update the status displayed on the page
              buttonElement.siblings('.status').text('delivered');
              // Remove the "Delivered" button
              buttonElement.remove();
            } else {
              alert('Failed to update status.');
            }
          }
        });
      });
    });
  </script>







</body>

</html>