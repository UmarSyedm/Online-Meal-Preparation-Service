<!DOCTYPE html>
<html>

<head>
    <title>Profile Page</title>
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

        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
            width: 90%
        }

        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        td {
            /* background-color: #E4F5D4; */
            font-weight: lighter;
        }

        input[type=number] {
            width: 75px; 
            border-radius: 8px; 
            padding: 2px 10px; 
            border: 3px solid #ccc;
        }

        input[type=number]:focus {
            border: 3px solid #ccc;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $db = new SQLite3('database/SMP.db');
    $username = $_SESSION['user_name'];
    ?>

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
            <a class="active1" href="Profile.php" class="split"><i class="bi-person-lines-fill"></i> Profile</a>
            <?php
            if ($_SESSION['user_name'] == 'Guest') {
                echo "<a href='SignUp.php' class='split'><i class='bi-person-plus'></i> SignUp</a>";
                echo "<a href='Login.php' class='split'><i class='bi-lock'></i> Login</a>";
            }
            ?>
        </nav>
        <?php
        if ($_SESSION['user_name'] == 'Guest') {
            header("location:Login.php");
        }
        ?>
    </div>

    <div class="main" style="padding-left:16px">

        <?php

        $query = "SELECT * FROM USER_INFO WHERE USER_NAME = '$username'";
        $result = $db->query($query);

        ?>

        <br>
        <h2 class="container">Edit User Details</h2>
        <br>
        <form class="container" method="post">
            <table>
                <?php
                while ($rows = $result->fetchArray()) {
                    ?>
                    <tr>
                        <th style="width:30%">Username</th>
                        <td>
                            <?php echo $rows['USER_NAME']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td>
                            <?php echo $rows['FIRST_NAME']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>
                            <?php echo $rows['LAST_NAME']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>
                            <?php echo $rows['EMAIL']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>
                            <?php echo $rows['PHONE_NUMBER']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Yeah of Birth</th>
                        <td>
                            <?php echo $rows['YOB']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Height (in cm)</th>
                        <td>
                            <?php echo $rows['HEIGHT']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Weight (in Kg)</th>
                        <td style="text-align: center;">
                            <input type="number" name="WEIGHT" min="40" max="200" step="1"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <th>Meal Preference</th>
                        <td>
                            <?php echo $rows['MEAL_PREF']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            <?php echo $rows['ADDRESS']; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br><br>
            <div class="container">
                <input class="btn btn-primary" type="submit" name="weight" value="Submit">
            </div>
            <br><br>
        </form>

        <?php

        if (isset($_POST['weight'])) {

            $weight = $_POST['WEIGHT'];

            $query = "UPDATE USER_INFO SET WEIGHT = '$weight'";
            $result = $db->querySingle($query);

            $command = escapeshellcmd('python BD_Groups.py ' . $username);
            $output = exec($command);

            echo "<script>location.href = 'Profile.php'</script>";
        }
        ?>

    </div>
</body>

</html>