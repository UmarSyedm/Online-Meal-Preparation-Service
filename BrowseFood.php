<!DOCTYPE html>
<html>

<head>
    <title>Browse Food Page</title>
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
            <a class="active" href="BrowseFood.php"><i class="bi-layout-text-sidebar-reverse"></i> Browse Food</a>
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

    <div class="main" style="padding-left:16px">
        <!-- <h2>Browse Food Page</h2> -->

        <?php

        $db = new SQLite3('database/SMP.db');

        $query = "SELECT * FROM FOODS";
        $result = $db->query($query);
        // $db->close();
        ?>

        <!-- <section> -->
        <br>
        <h2 class="container">Meals Info</h2><br>
        <table>
            <tr>
                <th>Title</th>
                <th>Calories</th>
                <th>Carbs</th>
                <th>Protein</th>
                <th>Fat</th>
                <th>Sugar</th>
                <th>Fiber</th>
                <th>Sodium</th>
                <th>Cost (₹)</th>
                <th>Meal Type</th>
                <th>Image</th>
            </tr>
            <?php

            while ($rows = $result->fetchArray()) {
                ?>
                <td>
                    <b><b>
                            <?php echo $rows['TITLE']; ?>
                        </b></b>
                </td>
                <td>
                    <?php echo $rows['CALORIES']; ?>
                </td>
                <td>
                    <?php echo $rows['CARBS']; ?>
                </td>
                <td>
                    <?php echo $rows['PROTEIN']; ?>
                </td>
                <td>
                    <?php echo $rows['FAT']; ?>
                </td>
                <td>
                    <?php echo $rows['SUGAR']; ?>
                </td>
                <td>
                    <?php echo $rows['FIBER']; ?>
                </td>
                <td>
                    <?php echo $rows['SODIUM']; ?>
                </td>
                <td>
                    <?php echo $rows['COST1']; ?>
                </td>
                <td>
                    <?php echo $rows['MEAL_TYPE']; ?>
                </td>
                <td>
                    <?php
                    echo '<img style="border-radius:8px;" width="100" height="90" src="data:image/jpeg;base64,' . base64_encode($rows['IMAGE']) . '"/>';
                    ?>
                </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br><br><br><br>
    </div>
</body>

</html>