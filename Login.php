<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
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
                echo "<a href='SignUp.php' class='split'><i class='bi-person-plus'></i> SignUp</a>";
                echo "<a class='active1' href='Login.php' class='split'><i class='bi-lock'></i> Login</a>";
            }
            ?>
        </nav>
    </div>

    <div class="main" style="padding-left:16px">

        <div>
            <form action="Login.php" method="post">
                <div class="container">

                    <div class="row">

                        <div class="col">
                            <br>
                            <h1>Login</h1>
                            <p>Enter your registered details.</p>
                            <p><label for="USER_NAME"><b>User Name</b></label>
                                <input class="form-control" placeholder="Enter Username" type="text" name="USER_NAME"
                                    required autofocus>
                            </p>

                            <p><label for="PASSWORD"><b>Password</b></label>
                                <input class="form-control" placeholder="Enter Password" type="password" name="PASSWORD"
                                    required>
                            </p>
                            <hr class="mb-3">

                            <p>By logging in your account you agree to our <a href="#">Terms & Privacy</a>.</p>
                            <input class="btn btn-primary" type="submit" name="create" value="Login">
                            <p>
                            <p>Don't have an account? <a href="SignUp.php">Sign Up</a>.</p>
                            </p>
                            <p>
                            <p>Click here for <a href="EmployeeLogin.php">Employee Login</a>.</p>
                            </p>
                        </div>

                        <div class="col">
                        </div>

                        <div class="col">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <?php
            if (isset($_POST['create'])) {

                $username = $_POST['USER_NAME'];
                $password = $_POST['PASSWORD'];

                session_start();

                $db = new SQLite3('database/SMP.db');
                $query = "SELECT * FROM USER_INFO WHERE USER_NAME = '$username' and PASSWORD = '$password'";
                $result = $db->querysingle($query);

                if ($result) {
                    $_SESSION['user_name'] = $username;

                    $pref_query = "SELECT MEAL_PREF FROM USER_INFO WHERE USER_NAME = '$username'";
                    $pref_result = $db->querySingle($pref_query);

                    $_SESSION['mealpref'] = $pref_result;

                    if ($pref_result == 'VEG') {
                        $_SESSION['themecolour'] = 'rgb(210, 255, 210)';
                        $_SESSION['bodytheme'] = 'darkolivegreen';
                        $_SESSION['mprightcolumn'] = 'lightgreen';
                        $_SESSION['homeimage'] = 'url("Images/image-lowgreen.jpg")';

                    } else {
                        $_SESSION['themecolour'] = '#FF7F7F';
                        $_SESSION['bodytheme'] = '#8D1919';
                        $_SESSION['mprightcolumn'] = '#FFBABA';
                        $_SESSION['homeimage'] = 'url("Images/image-lowmaroon.jpg")';

                    }

                    echo "<script>location.href = 'index.php'</script>";
                } else {
                    echo '<p style="padding-left: 70px;color:red;">Incorrect Username or Password!</p>';

                }
            }
            ?>
        </div>
    </div>
    </div>
</body>

</html>