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
  <title>Tom Mboya Library</title>

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


<!--Beginning of body-->

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
        <div id="menu-btn"> <i class="fas fa-bars"></i></div>
      </div>
      <!--end of responsive menu button-->

    </div>
  </header>
  <!--Header section ends here-->




  <!---->
  <!--Banner-->
  <section class="banner">

    <div class="bannercon">

      <!--bannertext-->
      <div class="bannertext">
        <h1>Bookhub: Discover, Shop & Stay Informed</h1>
        <p>Welcome to Tom Mboya Library, your premier destination to explore trending books, discover new arrivals and effortlessly purchase your desired titles.</p>
        <button class="prim"><a href="browseuser.php">Explore</a></button>
      </div>

      <!--bannerimage-->
      <div class="bannerimage">
        <img src="tomimages/background/lib.jpg" alt="">
      </div>

    </div>

  </section>
  <!--End of banner-->


  <!---->
  <!--Intro-->
  <section class="intro">

    <div class="introcon">

      <!--1st half section-->
      <div class="introrate">

        <!--Box 1-->
        <div class="ratebox">
          <p class="num">4.8</p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="rating">2390 Ratings</p>
          <p class="rating">Google Reviews</p>
        </div>

        <!--Box 2-->
        <div class="ratebox">
          <p class="num">A+</p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="rating">125 Ratings</p>
          <p class="rating">BBB Ratings</p>
        </div>

      </div>

      <!--2nd half section-->
      <div class="introtest">
        <h2>Trusted by numerous Book lovers & Readers</h2>
        <h3>Victor Muchemi</h3>
        <p>I absolutely love this website – it’s a one-stop shop for all my book needs, with a user-friendly interface and a wide selection of trending books and new arrivals!</p>
      </div>

    </div>

  </section>
  <!--End ofIntro-->


  <!---->
  <!--Services-->
  <section class="services">

    <div class="ourserv">
      <h2>Our Services </h2>

      <!--Flex service -->
      <div class="services-sec" id="services">

        <!--Box 1-->
        <div class="serv-box">

          <div class="serv-image">
            <img src="tomimages/background/catalog.jpg">
          </div>

          <div class="serv-text">
            <h3>Book Catalog: Browse ,Discover & Explore</h3>
            <p>Our catalog service offers a comprehensive range of products, providing detailed information and enabling easy browsing and borrowing.</p>
            <button class="prim"><a href="borrowuser.php">Explore</a></button>
          </div>

        </div>

        <!--Box 2-->
        <div class="serv-box res">

          <div class="serv-image">
            <img src="tomimages/background/donate2.jpeg">
          </div>

          <div class="serv-text">
            <h3>Donation Services</h3>
            <p>Whether you wish to share your love of reading, support educational programs, or give back to the community, we're here to make the process easy and convenient for you.</p>
            <button class="prim"><a href="donateuser.php">Donate</a></button>
          </div>

        </div>


        <!--Box 3-->
        <div class="serv-box res">

          <div class="serv-image">
            <img src="tomimages/background/eresource.jpg">
          </div>

          <div class="serv-text">
            <h3>Read and Borrow E-Books</h3>
            <p>Our e-resources service offers a vast collection of digital materials accessible anytime, providing valuable information and resources for research and learning purposes.</p>
            <button class="prim"><a href="browseuser.php">E-Resources</a></button>
          </div>

        </div>

      </div>

    </div>


  </section>
  <!--End of Services-->




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
        <a href="login.php" onclick="return confirm('Are you sure you want to logout?'); ">LogOut</a>
      </div>

    </div>

    <div class="copyright">
      <p>© 2023 Tom Mboya Library. All rights reserved.</p>
    </div>

  </footer>
  <!--End of Footer-->



  <!---->
  <!--Custom javascript file link-->
  <script src="JS FILES/tml.js"></script>


</body>

</html>