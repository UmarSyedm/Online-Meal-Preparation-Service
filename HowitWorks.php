<!DOCTYPE html>
<html>

<head>
    <title>How it Works Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">
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
            <a class="active" href="HowitWorks.php"><i class="bi-tags"></i> How it Works</a>
            <a href="BrowseFood.php"><i class="bi-layout-text-sidebar-reverse"></i> Browse Food</a>
            <a href="MealPlans.php"><i class="bi-egg-fried"></i> Meal Plans</a>
            <a href="AnalyzeMeals.php"><i class="bi-cup-straw"></i> Analyze Meals</a>
            <a href="Profile.php" class="split"><i class="bi-person-lines-fill"></i> Profile</a>
            <?php
            if ($_SESSION['user_name'] == 'Guest') {
                echo "<a href='SignUp.php' class='split'><i class='bi-person-plus'></i> SignUp</a>";
                echo "<a href='Login.php' class='split'><i class='bi-lock'></i> Login</a>";
            }
            ?>
        </nav>
    </div>

    <div class="main" style="padding-left:0px;padding-right:12px;padding-top:55px;">

        <div class="row" style='padding-left: 220px; padding-bottom:100px; padding-right: 0px; 
            background-color:<?php echo $_SESSION["bodytheme"] ?>; color: white;'>

            <div class="col">
                <br><br><br><br>
                <h1>How We Automate <br>Your Meal Planning</h1><br>
                <p>Smart Meal Planner helps you with the two most <br>important things to make your healthy diet a
                    success:
                </p><br>
                <p><b>1. Turn meal planning into an effortless <br>and magical experience</b></p>
                <p><b>2. Provide an endless supply of delicious <br>meals specific to your needs</b></p><br>
                <p>Let's see how Smart Meal Planner makes it happen!</p><br>
                <form action="SignUp.php">
                    <input class="btn btn-primary" type="Submit" name="Submit" value="Create a Free Account">
                </form>
            </div>
            <div class="col"><br><br><br>
                <img src="Images/howitworks1crop.jpg" style="padding-top: 35px; padding-left: 0px;text-align: left;"
                    width="500">
            </div>
        </div>
        <br><br><br><br>

        <div class="container">
            <div class="row">

                <h2 style="text-align: center;">Get Started in a few Easy Steps</h2><br><br>

                <div class="col"><br><br>
                    <img src="Images/browsehealthymeals.jpg" width="600" style="padding-left: 150px;">
                </div>
                <div class="col" style="padding-left:100px;"><br><br>
                    <h3>Browse
                        <br>
                        <a style="text-decoration:none;color:black; color:<?php echo $_SESSION["bodytheme"] ?>;"
                            href="BrowseFood.php"><b>Healthy Foods</b></a>
                    </h3><br>
                    <p>
                        We've got hundreds of delicious meals for every taste and <br>dietary preferences.
                        Browse them all and choose the ones <br>that are right for you.
                    </p>
                    <div class="text-left">
                        <img src="Images/arrow-left.jpg">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col"><br><br>
                    <h3 style="padding-left:180px;">Design a
                        <br>
                        <a style="text-decoration:none;color:black;padding-left:0px; 
                            color:<?php echo $_SESSION["bodytheme"] ?>;" href="MealPlans.php"><b>Meal Plan</b></a>
                    </h3><br>
                    <p style="padding-left:180px;">
                        Use our Meal Planning tool to add meals to your meal plan. You can either choose meals according
                        to BMI
                        or simply go for an automated balanced diet meal plan!
                    </p>
                    <div style="text-align:right;padding-right:30px;">
                        <img src="Images/arrow-right.jpg">
                    </div>
                </div>
                <div class="col"><br><br>
                    <img src="Images/designmealplan.jpg" width="500" style="text-align:left;padding-left: 55px;">
                </div><br>
            </div>

            <div class="row">

                <div class="col" style="padding:left:80px;"><br><br><br>
                    <img src="Images/revieworderscrop.jpg" width="580" style="padding-left: 180px;">
                </div>
                <div class="col" style="padding-left:100px;"><br><br><br>
                    <h3>Review
                        <br>
                        <a style="text-decoration:none; color:black; color:<?php echo $_SESSION["bodytheme"] ?>;"
                            href="Profile.php"><b>Your Orders</b></a>
                    </h3><br>
                    <p>
                        We've got hundreds of delicious meals for every taste and <br>dietary preference.
                        Browse them all and choose the ones <br>that are right for you.
                    </p>
                    <div class="text-left">
                        <img src="Images/arrow-left.jpg">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col"><br><br><br>
                    <h3 style="padding-left:180px;">Progress
                        <br>
                        <a style="text-decoration:none;color:black;padding-left:0px; 
                            color:<?php echo $_SESSION["bodytheme"] ?>;" href="MealPlans.php"><b>and Repeat</b></a>
                    </h3><br>
                    <p style="padding-left:180px;">
                        Make adjustments to your preferences, discover new meals, <br>or put your favorites on repeat.
                        Review nutrition stats, <br>track weight progress, and achieve your goals!
                    </p>
                </div>
                <div class="col"><br><br><br>
                    <img src="Images/checkboxsmall.jpg" width="230" style="text-align:left;padding-left: 55px;">
                </div><br>
            </div><br><br><br>

            <form style="text-align:center; padding-left: 20px;" action="SignUp.php">
                <input style="font-size: 23px; width: 200px; height: 60px;" class="btn btn-primary" type="Submit"
                    name="Submit" value="Get Started">
            </form><br><br><br>
        </div>
</body>

</html>