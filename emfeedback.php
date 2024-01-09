<!DOCTYPE html>
<html>

<head>
    <title>Employee Home Page</title>
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

    <div class='header' style='background-color:lightblue;'>
        <div class="row">
            <div class="column" style="width: 88%;">
                <h1><a style="text-decoration:none;color:black;" href="emindex.php">Smart Meal Planner</a></h1>
            </div>
            <div class="column" style="width: 6%; padding-top: 7px;">
                <form method="post">
                    <?php
                    if (isset($_POST['emcreate'])) {
                        session_start();
                        if (isset($_SESSION['emuser_name'])) {
                            session_destroy();
                        }
                        echo "<script>location.href='EmployeeLogin.php'</script>";
                    }
                    if ($_SESSION['user_name'] != 'Employee') { ?>

                        <input class="btn btn-primary" style="text-align: right; background-color:lightblue; color: blue;"
                            type="submit" name="emcreate" value="Logout">

                        <?php
                    }
                    ?>
                </form>
            </div>
            <div class="column" style="width: 6%;">
                <?php
                if (!isset($_SESSION['emuser_name'])) {
                    $_SESSION['emuser_name'] = 'Employee';
                }
                echo "<p style=\"text-align:right;\">Welcome,<br><b>" . $_SESSION['emuser_name'] . "</b></p>";
                ?>
            </div>
        </div>
    </div>

    <div class="topnav" style='background-color:lightblue;'>
        <nav>
            <a href="emindex.php"><i class="bi-house-fill"></i> Orders</a>
            <a href="emprofile.php" class="split"><i class="bi-person-lines-fill"></i> Site Stats</a>
            <a href="emadd.php"><i class="bi-clipboard-plus"></i> Add Meal</a>
            <a href="emreports.php"><i class="bi-book"></i>&ensp;Reports</a>
            <a href="emratingacc.php"><i class="bi-star"></i> Rating Accuracy</a>
            <a class="active" href="emfeedback.php"><i class="bi-star"></i> Feedback</a>
        </nav>
    </div>

    <div>
        <?php
        if ($_SESSION['emuser_name'] == 'Employee') {
            header("location:EmployeeLogin.php");
        }
        ?>
    </div>

    <div class="main" style="padding-left:16px">
        <!-- <h2>Employee Page</h2> -->

        <div style="padding-top: 40px; padding-bottom: 100px;">
            <?php
            $db = new SQLite3('database/SMP.db');
            $emusername = $_SESSION['emuser_name'];

            $query = "SELECT NAME, EMAIL, COMMENTS, SUBMIT_DATE FROM FEEDBACK
                        ORDER BY SUBMIT_DATE";

            // $query = "SELECT USER_NAME, TITLE, MEAL_TYPE, ORDER_DATE, ADDRESS, DELIVERY_DATE, PAYMENT_STATUS 
            //             FROM ORDERS WHERE DELIVERY_DATE > DATETIME()
            //             UNION ALL
            //             SELECT USER_NAME, TITLE, MEAL_TYPE, ORDER_DATE, ADDRESS, DELIVERY_DATE, PAYMENT_STATUS 
            //             FROM BD_ORDERS WHERE DELIVERY_DATE > DATETIME() ORDER BY DELIVERY_DATE";

            $result = $db->query($query);
            ?>

            <h2 class="container">Customer Feedback</h2>
            <br>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Feedback</th>
                </tr>
                <?php
                while ($rows = $result->fetchArray()) {
                    ?>
                    <td>
                        <?php echo $rows['NAME']; ?>
                    </td>
                    <td>
                        <?php echo $rows['EMAIL']; ?>
                    </td>
                    <td>
                        <?php echo $rows['COMMENTS']; ?>
                    </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>


</body>

</html>