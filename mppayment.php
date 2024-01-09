<!DOCTYPE html>
<html>

<head>
    <title>Payment Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">
    <style>
        th {
            text-align: center;
            padding: 8px;
        }

        td {
            text-align: center;
            padding: 12px;
        }
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
            <a class="active" href="MealPlans.php"><i class="bi-egg-fried"></i> Meal Plans</a>
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
    <div>
        <?php
        if ($_SESSION['user_name'] == 'Guest') {
            header("location:Login.php");
        }
        ?>
    </div>
    <div class="main2" style="padding-left:9px;padding-right:12px;">
        <h2>Payment Page</h2>

        <div>
            <?php

            $db = new SQLite3('database/SMP.db');

            $username = $_SESSION['user_name'];
            $payid = $_SESSION['PAY_ID'];

            $query = "SELECT MAX(ID) AS ID, TITLE, MEAL_TYPE, COUNT(*) AS COUNT, COST, COST * COUNT(*) AS MEAL_COST 
                        FROM BD_ORDERS WHERE USER_NAME = '$username' AND PAYMENT_STATUS = 'NOT PAID' AND PAY_ID = '$payid'
                        GROUP BY TITLE, MEAL_TYPE, COST
                        ORDER BY MAX(ID)";

            /*$query = "SELECT DISTINCT(ID) AS ID, A.TITLE AS TITLE, A.MEAL_TYPE AS MEAL_TYPE, COUNT, COST1, (COUNT * COST1) AS MEAL_COST  FROM 
            (SELECT MAX(ID) AS ID, TITLE, MEAL_TYPE, COUNT(*) AS COUNT
            FROM ORDERS
            WHERE USER_NAME = '$username' AND PAYMENT_STATUS = 'NOT PAID'
            GROUP BY TITLE, MEAL_TYPE) A,
            (SELECT TITLE, MEAL_TYPE, COST1 FROM FOODS) B
            WHERE A.TITLE = B.TITLE
            AND A.MEAL_TYPE = B.MEAL_TYPE
            ORDER BY ID"; */

            $result = $db->query($query);
            ?>

            <br><br>

            <div class="container">

                <h2>Your Order Info</h2>
                <br>
                <table style="width:100%;text-align:center;">
                    <tr>
                        <th>
                            <hr class="mb-3">
                            ID
                            <hr class="mb-3">
                        </th>
                        <th>
                            <hr class="mb-3">
                            Title
                            <hr class="mb-3">
                        </th>
                        <th>
                            <hr class="mb-3">
                            Meal Type
                            <hr class="mb-3">
                        </th>
                        <th>
                            <hr class="mb-3">
                            Count
                            <hr class="mb-3">
                        </th>
                        <th>
                            <hr class="mb-3">
                            Cost Per Meal
                            <hr class="mb-3">
                        </th>
                        <th>
                            <hr class="mb-3">
                            Meal Cost
                            <hr class="mb-3">
                        </th>
                    </tr>
                    <?php
                    while ($rows = $result->fetchArray()) {
                        ?>
                        <td>
                            <?php echo $rows['ID']; ?>
                        </td>
                        <td>
                            <?php echo $rows['TITLE']; ?>
                        </td>
                        <td>
                            <?php echo $rows['MEAL_TYPE']; ?>
                        </td>
                        <td>
                            <?php echo $rows['COUNT']; ?>
                        </td>
                        <td>
                            <?php echo $rows['COST']; ?>
                        </td>
                        <td>
                            <?php echo $rows['MEAL_COST']; ?>
                        </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

                <hr class="mb-3">
                <br>
                <div class="row">
                    <div class="col">
                    </div>
                    <div class="col">
                    </div>
                    <div class="col">
                    </div>

                    <div class="col">

                        <?php

                        $query = "SELECT ROUND(SUM(COST)) FROM BD_ORDERS
                                WHERE USER_NAME = '$username' AND PAYMENT_STATUS = 'NOT PAID' AND PAY_ID = $payid";
                        $result = $db->querySingle($query);
                        ?>

                        <h4>Total Meal Cost = ₹
                            <?php echo $result; ?>
                        </h4>

                    </div>
                </div>
                <div>
                    
                </div>

                <hr class="mb-3">
                <form method="post">
                    <div class="container">
                        <p>Pay below:</p>
                        <input class="btn btn-primary" type="submit" name="pay" value="Pay">
                    </div>
                </form><br><br><br>
                <?php
                if (isset($_POST['pay'])) {

                    $username = $_SESSION['user_name'];

                    $db = new SQLite3('database/SMP.db');
                    $query = "UPDATE BD_ORDERS SET PAYMENT_STATUS = 'PAID' WHERE USER_NAME = '$username' AND PAY_ID = $payid";
                    $result = $db->query($query);

                    if ($result) {
                        echo "<script>location.href = 'Profile.php'</script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>