<!DOCTYPE html>
<html>

<head>
    <title>Sign Up Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">
    <style>
        body {
            background-image: url('Images/wp-1.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
</head>

<body>
    <?php session_start(); ?>

    <div class='header' style='background-color:<?php echo $_SESSION["themecolour"] ?>;'>
        <div class="row">
            <div class="col">
                <h1><a style="text-decoration:none;color:black;" href="index.php">Smart Meal Planner</a></h1>
            </div>
            <div class="col">
                <?php
                if (!isset($_SESSION['user_name'])) {
                    $_SESSION['user_name'] = 'Guest';
                }
                echo "<p style=\"text-align:right;\">Welcome,<br><b>" . $_SESSION['user_name'] . "</b></p>";
                ?>
            </div>
        </div>
    </div>

    <div class="topnav" style='background-color:<?php echo $_SESSION["themecolour"] ?>;'>
        <nav>
            <a href="index.php"><i class="bi-house-fill"></i> Home</a>
            <a href="HowitWorks.php"><i class="bi-tags"></i> How it Works</a>
            <a href="BrowseFood.php"><i class="bi-layout-text-sidebar-reverse"></i> Browse Food</a>
            <a href="MealPlans.php"><i class="bi-egg-fried"></i> Meal Plans</a>
            <a href="AnalyzeMeals.php"><i class="bi-cup-straw"></i> Analyze Meals</a>
            <a href="Profile.php" class="split"><i class="bi-person-lines-fill"></i> Profile</a>
            <?php
            if ($_SESSION['user_name'] == 'Guest') {
                echo "<a class='active1' href='SignUp.php' class='split'><i class='bi-person-plus'></i> SignUp</a>";
                echo "<a href='Login.php' class='split'><i class='bi-lock'></i> Login</a>";
            }
            ?>
        </nav>
    </div>

    <div class="main" style="padding-left:16px">

        <div>
            <form action="SignUp.php" method="post">
                <div class="container">

                    <h1>Sign Up</h1>
                    <p>Fill up the form with correct values.</p>

                    <div class="row">
                        <div class="col">

                            <p><label for="USER_NAME"><b>User Name</b></label>
                                <input class="form-control" placeholder="Enter Username" type="text" name="USER_NAME"
                                    required autofocus>
                            </p>

                            <p><label for="PASSWORD"><b>Password</b></label>
                                <input class="form-control" placeholder="Enter Password" type="password" name="PASSWORD"
                                    required>
                            </p>

                            <p><label for="FIRST_NAME"><b>First Name</b></label>
                                <input class="form-control" placeholder="Enter Firstname" type="text" name="FIRST_NAME"
                                    required>
                            </p>

                            <p><label for="LAST_NAME"><b>Last Name</b></label>
                                <input class="form-control" placeholder="Enter Lastname" type="text" name="LAST_NAME"
                                    required>
                            </p>

                            <p><label for="EMAIL"><b>Email Address</b></label>
                                <input class="form-control" placeholder="Enter Email" type="email" name="EMAIL"
                                    required>
                            </p>

                        </div>
                        <div class="col">

                            <p><label for="PHONE_NUMBER"><b>Phone Number</b></label>
                                <input class="form-control" placeholder="Enter Phone Number" type="text" 
                                name="PHONE_NUMBER" min="6000000000" max="9999999999" required>
                            </p>

                            <p><label for="YOB"><b>YOB</b></label>
                                <input class="form-control" placeholder="Enter Year of Birth" type="integer" name="YOB"
                                    min="1940" max="2013" required>
                            </p>

                            <p><label for="HEIGHT"><b>Height</b></label>
                                <input class="form-control" placeholder="Enter Height in cm" type="integer" name="HEIGHT" 
                                    min="120" max="250" required>
                            </p>

                            <p><label for="WEIGHT"><b>Weight</b></label>
                                <input class="form-control" placeholder="Enter Weight in Kg" type="integer" name="WEIGHT" 
                                min="40" max="300" required>
                            </p>
                            <p>
                                <label style="padding-bottom:6px;" for="MEAL_PREF"><b>Meal Preference</b></label><br>
                                <input type="radio" name="MEAL_PREF" value="VEG" required>
                                <label for="VEG">Veg &emsp;</label>
                                <input type="radio" name="MEAL_PREF" value="NONVEG" required>
                                <label for="NONVEG">Non Veg</label>
                            </p>
                        </div>
                        <div class="col">
                            <p><label for="ADDRESS"><b>Address</b></label>
                                <textarea class="form-control" placeholder="Enter your Address" name="ADDRESS" cols="40"
                                    rows="3" required></textarea>
                            </p>

                        </div>

                        <hr class="mb-3">

                    </div>

                    <p><input type="checkbox" id="exampleCheck" required>
                        <label for="exampleCheck">Agree to our <a href="#">Terms & Privacy</a>.</label>
                    </p>

                    <!-- <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> -->
                    <input class="btn btn-primary" type="submit" name="create" value="Sign Up">

                </div>
            </form>

        </div>
        <div class="container">
            <!--  <p>
            <p><input type="checkbox" id="exampleCheck">
                <label for="exampleCheck">Sign me up for exclusive Email offers</label>
            </p>
            </p> -->
        </div>
        <div>
            <?php
            if (isset($_POST['create'])) {

                $username = $_POST['USER_NAME'];
                $firstname = $_POST['FIRST_NAME'];
                $lastname = $_POST['LAST_NAME'];
                $email = $_POST['EMAIL'];
                $phonenumber = $_POST['PHONE_NUMBER'];
                $password = $_POST['PASSWORD'];
                $yob = $_POST['YOB'];
                $height = $_POST['HEIGHT'];
                $weight = $_POST['WEIGHT'];
                $mealpref = $_POST['MEAL_PREF'];
                $address = $_POST['ADDRESS'];

                $db = new SQLite3('database/SMP.db');

                $result = $db->exec("INSERT INTO USER_INFO(USER_NAME, FIRST_NAME, LAST_NAME, EMAIL, PHONE_NUMBER, PASSWORD, YOB, HEIGHT, WEIGHT, MEAL_PREF, ADDRESS) 
                VALUES('$username', '$firstname', '$lastname', '$email', '$phonenumber', '$password', '$yob', '$height', '$weight', '$mealpref', '$address')");

                if ($result) {
                    session_start();
                    $_SESSION['user_name'] = $username;

                    if ($mealpref == 'VEG') {
                        $_SESSION['themecolour'] = 'rgb(210, 255, 210)';
                        $_SESSION['bodytheme'] = 'darkolivegreen';
                        $_SESSION['mprightcolumn'] = 'lightgreen';
                        $_SESSION['homeimage'] = 'url("Images/image-lowgreen.jpg")';


                    } else {
                        $_SESSION['themecolour'] = '#FF7F7F';
                        $_SESSION['bodytheme'] = '#8D1919';
                        $_SESSION['mprightcolumn'] = 'white';
                        $_SESSION['homeimage'] = 'url("Images/image-lowmaroon.jpg")';

                    }

                    $command = escapeshellcmd('python BD_Groups.py ' . $username);
                    $output = exec($command);
                    echo "<script>location.href = 'index.php'</script>";

                } else {
                    echo '<div class="container">
                            <h5>The Username/Email Address/Phone Number already exists!</h5>
                            </div>';
                }
            }
            ?>

            <div class="container signin">
                <p>
                <p>Already have an account? <a href="Login.php">Login</a>.</p>
                </p>
            </div>

        </div>
    </div>
</body>

</html>