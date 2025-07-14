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
  <title>Browse - Tom Mboya Library</title>

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


  <!---->
  <!--Trending books-->
  <section class="book">

    <div class="booksec">

      <!--Book Category-->
      <div class="booksecbox">
        <h3>Trending 🔥</h3>
        <div class="bookdetailsbox">

          <?php
          $select_trendingbook = mysqli_query($conn, "SELECT * FROM `trendingbooks`") or die('query failed');
          if (mysqli_num_rows($select_trendingbook) > 0) {
            while ($fetch_trendingbook = mysqli_fetch_assoc($select_trendingbook)) {
              // Retrieve the serial number for each book
              $serialnumber = $fetch_trendingbook['serialnumber'];

          ?>

              <form method="post" class="bookdetails" action="trending.php">
                <input type="hidden" name="serialnumber" value="<?php echo $serialnumber; ?>">
                <img class="imagecover" src="tomimages/background/<?php echo $fetch_trendingbook['image']; ?>" alt="">
                <div class="bookname"><?php echo $fetch_trendingbook['name']; ?></div>
                <div class="booknumber"><?php echo $serialnumber; ?></div>
                <button class="prim" type="submit">Read</button>
              </form>



          <?php
            }
          }
          ?>

        </div>

      </div>

    </div>


  </section>
  <!--end of trending books-->



  <!---->
  <!--Romance Boooks-->
  <section class="rombook">

    <div class="booksec">

      <!--Book Category-->
      <div class="booksecbox">
        <h3>Romance ❤</h3>
        <div class="bookdetailsbox">

          <?php
          $select_rombook = mysqli_query($conn, "SELECT * FROM `romancebooks`") or die('query failed');
          if (mysqli_num_rows($select_rombook) > 0) {
            while ($fetch_rombook = mysqli_fetch_assoc($select_rombook)) {
              // Retrieve the serial number for each book
              $serialnumber = $fetch_rombook['serialnumber'];
          ?>

              <form method="post" class="bookdetails" action="romance.php">
                <input type="hidden" name="serialnumber" value="<?php echo $serialnumber; ?>">
                <img class="imagecover" src="tomimages/background/<?php echo $fetch_rombook['image']; ?>" alt="">
                <div class="bookname"><?php echo $fetch_rombook['name']; ?></div>
                <div class="booknumber"><?php echo $serialnumber; ?></div>
                <button class="prim" type="submit">Read</button>
              </form>

          <?php
            }
          }
          ?>

        </div>

      </div>

    </div>


  </section>
  <!--end of romance books-->


  <!---->
  <!--Kids Boooks-->
  <section class="kidsbook">

    <div class="booksec">

      <!--Book Category-->
      <div class="booksecbox">
        <h3>Kids 🧒</h3>
        <div class="bookdetailsbox">

          <?php
          $select_kidsbook = mysqli_query($conn, "SELECT * FROM `kidsbooks`") or die('query failed');
          if (mysqli_num_rows($select_kidsbook) > 0) {
            while ($fetch_kidsbook = mysqli_fetch_assoc($select_kidsbook)) {
              // Retrieve the serial number for each book
              $serialnumber = $fetch_kidsbook['serialnumber'];
          ?>

              <form method="post" class="bookdetails" action="kids.php">
                <input type="hidden" name="serialnumber" value="<?php echo $serialnumber; ?>">
                <img class="imagecover" src="tomimages/background/<?php echo $fetch_kidsbook['image']; ?>" alt="">
                <div class="bookname"><?php echo $fetch_kidsbook['name']; ?></div>
                <div class="booknumber"><?php echo $serialnumber; ?></div>
                <button class="prim" type="submit">Read</button>
              </form>

          <?php
            }
          }
          ?>

        </div>

      </div>

    </div>


  </section>
  <!--end of kids books-->


  <!---->
  <!--Horror Boooks-->
  <section class="horrorbook">

    <div class="booksec">

      <!--Book Category-->
      <div class="booksecbox">
        <h3>Horror 👻</h3>
        <div class="bookdetailsbox">

          <?php
          $select_horrorbook = mysqli_query($conn, "SELECT * FROM `horrorbooks`") or die('query failed');
          if (mysqli_num_rows($select_horrorbook) > 0) {
            while ($fetch_horrorbook = mysqli_fetch_assoc($select_horrorbook)) {
              // Retrieve the serial number for each book
              $serialnumber = $fetch_horrorbook['serialnumber'];
          ?>

              <form method="post" class="bookdetails" action="horror.php">
                <input type="hidden" name="serialnumber" value="<?php echo $serialnumber; ?>">
                <img class="imagecover" src="tomimages/background/<?php echo $fetch_horrorbook['image']; ?>" alt="">
                <div class="bookname"><?php echo $fetch_horrorbook['name']; ?></div>
                <div class="booknumber"><?php echo $serialnumber; ?></div>
                <button class="prim" type="submit">Read</button>
              </form>

          <?php
            }
          }
          ?>

        </div>

      </div>

    </div>


  </section>
  <!--end of horror books-->



  <!---->
  <!--Footer-->
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


</body>

</html>