<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){
    $adname = mysqli_real_escape_string($conn, $_POST['dname']);
    $pass = mysqli_real_escape_string($conn, $_POST['dpassword']);

    $select = mysqli_query($conn, "SELECT *FROM `deliverystaff` WHERE dname ='$adname' AND dpassword = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['delivery_id'] = $row['id'];
        header('location:deliverydashboard.php');
    }
    else {
        $message[] = 'Incorrect Username ❌'; 
    }


}

?>

<!DOCTYPE html>
<html lang="en" dir="1tr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Delivery Staff Login - Tom Mboya Library</title>

    <!--Font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>

    <!--Unicons link-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!---aos link stylesheet-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!--Awesome font kit-->
    <script src="https://kit.fontawesome.com/caea6e076b.js" crossorigin="anonymous"></script>
    
    <!--Custom CSS link-->
    <link rel="stylesheet" href="tml.css"/>

  </head>

  <body>


  <section class="register admin">

        <div class="form-authorization">

            <form action="" method="post">

                <!--Logo-->
                <div class="registerlogo">
                    <a href="index.php"><img src="tomimages/logo/TML PROJECT.png" alt="Tom Mboya Library"></a>
                </div>

                <h3>Delivery Staff Login</h3>

                <div class="inputs">
                <input type="text" name="dname" required placeholder="Delivery staff username" class="box">
                <input type="password" name="dpassword" required placeholder="Password" class="box">
                <input type="submit" name="submit" class="prim" value="Login">
                </div>

                <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
                    }
                }
                ?>

            </form>

        </div>
        
    </section>
    
  </body>

</html>