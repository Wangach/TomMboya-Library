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
    <title>About Us - Tom Mboya Library</title>

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


    <!--About bnner--->
    <section class="about-banner"></section>
    <!--End of about banner-->


    <!--About us section-->
    <section class="abouttext">
        <h5>About Tom Mboya Library</h5>
        <p>Welcome to the Tom Mboya Library, a hub of knowledge, learning and community engagement nestled in the heart of Kisumu. Our library is dedicated to promoting literacy, education and culture in the vibrant city of Kisumu, Kenya.</p>
        <h5>Our Mission</h5>
        <p class="about-intro">At Tom Mboya Library, our mission is to empower individuals and enrich the community through access to quality educational resources, fostering a lifelong love for reading and supporting personal and professional development.</p>
        <h5>A Hub of Knowledge</h5>
        <p class="about-intro">With an extensive collection of books, periodicals and digital resources, we are committed to providing a welcoming space where people of all ages can explore, discover and learn. Whether you're a student seeking academic resources, a professional looking to expand your knowledge, or a leisure reader in search of a captivating story, we have something for everyone.</p>
        <h5>Community and Culture</h5>
        <p class="about-intro">We believe in the power of community and culture. Tom Mboya Library is more than just a collection of books; it's a gathering place where people come together to share ideas, engage in discussions and celebrate the rich culture of Kisumu. Our library hosts a variety of events, including book clubs, workshops and cultural exhibitions.</p>
        <h5>Dedicated Staff</h5>
        <p class="about-intro">Our dedicated and friendly staff is here to assist you in finding the right resources, answer your questions and create a welcoming environment for all visitors. We are passionate about promoting literacy and learning and we're always here to help you on your educational journey.</p>
        <h5>Get Involved</h5>
        <p class="about-intro">Tom Mboya Library welcomes the involvement of the community. If you'd like to volunteer, donate, or partner with us in any way, please don't hesitate to get in touch. Your support can make a significant difference in achieving our mission of expanding access to knowledge and education.</p>
        <h5>Visit Us</h5>
        <p class="about-intro">We invite you to visit Tom Mboya Library in Kisumu, explore our collection and become part of our growing community of learners, readers and culture enthusiasts. Whether you're a local resident or a visitor to Kisumu, we look forward to having you here.</p>
        <h5 id="opening">Opening Hours</h5>
        <p class="about-intro">Monday: 9:00 AM - 5:00 PM<br>Tuesday: 9:00 AM - 5:00 PM<br>Wednesday: 9:00 AM - 5:00 PM<br>Thursday: 9:00 AM - 5:00 PM<br>Friday: 9:00 AM - 5:00 PM<br>Saturday: 10:00 AM - 2:00 PM<br>Sunday: Closed.</p>
        <p class="final">Please note that our library is closed on Sundays and we offer extended hours on Saturdays to accommodate weekend visitors. Our friendly staff will be available during these hours to assist you and make your visit a pleasant experience.</p>
        <p class="final">Thank you for your interest in Tom Mboya Library. We are excited to be a part of your educational and cultural journey.</p>
        <p class="final">For more information and the latest updates, please explore our website and follow us on social media.</p>
    </section>
    <!--End of about us-->

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
                <a href="#opening">Opening Hours</a>
                <a href="about.php">About</a>
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