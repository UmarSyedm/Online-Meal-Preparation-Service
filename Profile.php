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

        /*style="text-align: center;color: #006600;font-size: xx-large;font-family: 'Gill Sans', 'Gill Sans MT',' Calibri', 'Trebuchet MS', 'sans-serif';">*/

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
        <!-- <h2 class="container" style="padding-top: 30px;">Profile Page</h2> -->

        <form action="Profile.php" method="post">
            <div class="container" style="text-align:right;">

                <br><input class="btn btn-primary" type="submit" name="create" value="Logout">

            </div>
            <div>
                <?php
                if (isset($_POST['create'])) {
                    session_start();
                    if (isset($_SESSION['user_name'])) {
                        session_destroy();
                    }
                    echo "<script>location.href='index.php'</script>";
                }
                ?>
            </div>
        </form>

        <div>

            <!-- <h4><a href="Profile.php">User Info</a></h4>
            <h4><a href="Profile.php">Orders Info</a></h4> -->

            <?php
            $db = new SQLite3('database/SMP.db');
            $username = $_SESSION['user_name'];

            $query = "SELECT * FROM USER_INFO WHERE USER_NAME = '$username'";

            $result = $db->query($query);
            ?>

            <h2 class="container">User Info</h2>
            <div class="container">
                <form action="Edit.php" method="post">
                    <input class="btn btn-primary" type="submit" name="edit" value="Edit">
                </form>
            </div>
            <?php
            if (isset($_POST['edit'])) {

            }
            ?>
            <br>
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
                        <td>
                            <?php echo $rows['WEIGHT']; ?>
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
        </div>

        <div>
            <?php
            $db = new SQLite3('database/SMP.db');
            $username = $_SESSION['user_name'];

            $query = "SELECT * FROM (SELECT TITLE, MEAL_TYPE, ORDER_DATE, ADDRESS, DELIVERY_DATE 
                        FROM ORDERS WHERE USER_NAME = '$username' AND DELIVERY_DATE > DATETIME()
                        AND PAYMENT_STATUS = 'PAID'
                        UNION ALL
                        SELECT TITLE, MEAL_TYPE, ORDER_DATE, ADDRESS, DELIVERY_DATE 
                        FROM BD_ORDERS WHERE USER_NAME = '$username' AND DELIVERY_DATE > DATETIME()
                        AND PAYMENT_STATUS = 'PAID')
                        ORDER BY DELIVERY_DATE";
            $result = $db->query($query);
            ?>
            <br><br><br>
            <h2 class="container">Upcoming Orders Info</h2>
            <br>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Meal Type</th>
                    <th>Order Date</th>
                    <th>Address</th>
                    <th>Delivery Date</th>
                </tr>
                <?php
                while ($rows = $result->fetchArray()) {
                    ?>
                    <td>
                        <?php echo $rows['TITLE']; ?>
                    </td>
                    <td>
                        <?php echo $rows['MEAL_TYPE']; ?>
                    </td>
                    <td>
                        <?php echo $rows['ORDER_DATE']; ?>
                    </td>
                    <td>
                        <?php echo $rows['ADDRESS']; ?>
                    </td>
                    <td>
                        <?php echo $rows['DELIVERY_DATE']; ?>
                    </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>

        <div>

            <?php
            $db = new SQLite3('database/SMP.db');

            $query = "SELECT DISTINCT(TITLE), PAY_ID FROM ORDERS WHERE USER_NAME = '$username'
                        AND PAYMENT_STATUS = 'PAID' AND PAY_ID NOT IN (SELECT DISTINCT(PAY_ID) 
                        from RATING WHERE USER_NAME = '$username')
                        UNION ALL
                        SELECT DISTINCT(TITLE), PAY_ID FROM BD_ORDERS WHERE USER_NAME = '$username'
                        AND PAYMENT_STATUS = 'PAID' AND PAY_ID NOT IN (SELECT DISTINCT(PAY_ID) 
                        FROM RATING WHERE USER_NAME = '$username')";
            $result = $db->query($query);
            // $db->close();
            ?>

            <br><br><br>
            <!-- <section> -->
            <h2 class="container">Give Us a Rating on your Past Orders</h2>
            <br>
            <form method="post">
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Pay ID</th>
                        <th>Rating</th>
                    </tr>
                    <?php

                    while ($rows = $result->fetchArray()) {
                        ?>
                        <td>
                            <?php echo $rows['TITLE'];
                            $title[] = $rows['TITLE'];
                            ?>
                        </td>
                        <td>
                            <?php echo $rows['PAY_ID'];
                            $payid[] = $rows['PAY_ID'];
                            ?>
                        </td>
                        <td>
                            <input type="number" class="date form-control" name="RATING[]" min="1" max="5" step="0.1"
                                style="width: 75px; text-align: center;" required>
                        </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <br><br>
                <div class="container">
                    <input class="btn btn-primary" type="submit" name="rate" value="Submit">
                </div>
                <br><br>
            </form>

            <?php

            if (isset($_POST['rate'])) {

                $rating = $_POST['RATING'];

                for ($i = 0; $i < count($rating); $i++) {

                    $result = $db->exec("INSERT INTO RATING (USER_NAME, TITLE, PAY_ID, RATING)
                    VALUES ('$username', '$title[$i]', '$payid[$i]', '$rating[$i]')");
                }
                $query = "UPDATE FOODS SET USER_RATING = (SELECT AVG(RATING) FROM RATING WHERE FOODS.TITLE = RATING.TITLE)";
                $result = $db->query($query);
                $query = "UPDATE FOODS SET USER_RATING_COUNT = (SELECT count(*) FROM RATING  WHERE FOODS.TITLE = RATING.TITLE)";
                $result = $db->query($query);
                $query = "UPDATE FOODS SET USER_RANKING = (SELECT RANK FROM (SELECT TITLE, ROW_NUMBER() 
                            OVER(ORDER BY USER_RATING DESC) RANK FROM FOODS) R WHERE FOODS.TITLE = R.TITLE)";
                $result = $db->query($query);

                echo "<script>location.href = 'Profile.php'</script>";
            }
            ?>
            <br><br>
        </div>
    </div>
</body>

</html>