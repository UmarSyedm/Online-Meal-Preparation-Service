<!DOCTYPE html>
<html>

<head>
    <title>Automate Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">
    <link rel="stylesheet" href="mpautomate.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

        <form action="" method="post">

            <div class="row"> <!-- Row -->

                <div class="column" style="width:80%; background-color:<?php echo $_SESSION['bodytheme'] ?>;">
                    <!-- Left Column -->
                    <br>

                    <?php
                    for ($x = 1; $x <= 7; $x++) {
                        ?>

                        <div class="row"> <!-- For Days -->

                            <?php

                            $db = new SQLite3('database/SMP.db');
                            $username = $_SESSION['user_name'];

                            // $query = "SELECT MEAL_TYPE, TITLE, CALORIES, CARBS, PROTEIN, FAT 
                            //             FROM BD_MEALS WHERE DAY = '1' AND USER_NAME = '$username'";
                            // $result = $db->query($query);
                        
                            $query1 = "SELECT SUM(CALORIES) AS TOTAL_CALORIES, SUM(CARBS*4) AS TOTAL_CARBS, 
                                    SUM(PROTEIN*4) AS TOTAL_PROTEIN, SUM(FAT*9) AS TOTAL_FAT FROM BD_GROUPS 
                                    WHERE DAY_INDEX = '$x' AND USER_NAME = '$username'";
                            $totalresult = $db->query($query1);
                            $rec = $totalresult->fetchArray();

                            $query = "SELECT MEAL_TYPE, TITLE, CALORIES, CARBS, PROTEIN, FAT FROM BD_GROUPS 
                                    WHERE DAY_INDEX = '$x' AND USER_NAME = '$username'
                                    UNION ALL
                                    SELECT NULL, 'Total Calories', SUM(CALORIES) AS TOTAL_CALORIES, 
                                    SUM(CARBS*4) AS TOTAL_CARBS, 
                                    SUM(PROTEIN*4) AS TOTAL_PROTEIN, 
                                    SUM(FAT*9) AS TOTAL_FAT 
                                    FROM BD_GROUPS 
                                    WHERE DAY_INDEX = '$x' AND USER_NAME = '$username'";
                            $result = $db->query($query);

                            ?>

                            <div class="mealbox">
                                <h3>Day -
                                    <?php echo $x; ?>
                                </h3>
                                <div class="mealtable">
                                    <div class="vertical-menu">
                                        <div class="row" style="width:100%;">
                                            <div class="column" style="width:60%;">
                                                <table>
                                                    <tr>
                                                        <th style="width:82px;">Meal</th>
                                                        <th style="width:280px;">Title</th>
                                                        <th style="width:82px;">Calories</th>
                                                        <th style="width:82px;">Carbs</th>
                                                        <th style="width:80px;">Protein</th>
                                                        <th style="width:80px;">Fat</th>
                                                    </tr>

                                                    <?php

                                                    while ($rows = $result->fetchArray()) {
                                                        ?>
                                                        <td>
                                                            <?php echo $rows['MEAL_TYPE']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['TITLE']; ?>
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
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                                <p style="padding-top:8px;"><b>Variance = </b>
                                                    <?php echo ROUND(abs(($rec[1] / $rec[0] * 100) - 62) + abs(($rec[2] / $rec[0] * 100) - 13) + abs(($rec[3] / $rec[0] * 100) - 25), 2) . '%'; ?>
                                                </p>
                                            </div>

                                            <div class="column" style="width:40%;">
                                                <h5 style="text-align:center;"><b>Calories Ratio</b></h5>

                                                <div id="myChart<?php echo $x; ?>">
                                                </div>

                                                <script>
                                                    google.charts.load('current', { 'packages': ['corechart'] });
                                                    google.charts.setOnLoadCallback(drawChart);

                                                    function drawChart() {
                                                        const data = google.visualization.arrayToDataTable([
                                                            ['Nutrients', 'Mhl'],
                                                            ['Carbs', <?php echo $rec[1]; ?>],
                                                            ['Protein', <?php echo $rec[2]; ?>],
                                                            ['Fat', <?php echo $rec[3]; ?>]
                                                        ]);

                                                        const options = {
                                                            fontSize: 14,
                                                            title: 'For a Balanced Diet - (Carbs: 62%, Protein: 13%, Fat: 25%)',
                                                            // titlePosition: 'none',
                                                            backgroundColor: { fill: 'transparent' },
                                                            is3D: true,
                                                            'width': 444,
                                                            'height': 262,
                                                            'chartArea': { 'width': '100%', 'height': '80%' },
                                                            'legend': { 'position': 'bottom' }
                                                        };

                                                        const chart = new google.visualization.PieChart(document.getElementById('myChart<?php echo $x; ?>'));
                                                        chart.draw(data, options);
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- For Days -->
                        <br>
                        <?php
                    }

                    $_SESSION['PAY_ID'] = rand(1000, 9999);

                    if (isset($_POST['automatepayment'])) {

                        $username = $_SESSION['user_name'];
                        $startdate = $_POST['STARTDATE'];
                        $noofweeks = $_POST['NOOFWEEKS'];
                        $payid = $_SESSION['PAY_ID'];

                        $query = "SELECT ID, USER_NAME, TITLE, MEAL_TYPE, DAY_INDEX FROM BD_GROUPS WHERE USER_NAME = '$username'";
                        $result = $db->query($query);

                        for ($i = 0; $i < ($noofweeks); $i++) {
                            while ($row = $result->fetchArray()) {

                                $j = ($row[4] - 1 + (($i * 7) + 1)) - 1;

                                $deliverydate = date('Y-m-d', strtotime("+$j day", strtotime($startdate)));

                                $insertresult = $db->exec("INSERT INTO BD_ORDERS (USER_NAME, TITLE, MEAL_TYPE, DELIVERY_DATE, PAY_ID) 
                                                            VALUES ('$row[1]', '$row[2]', '$row[3]', '$deliverydate', '$payid')");
                            }
                        }
                        echo "<script>location.href = 'mppayment.php'</script>";
                    }
                    ?>
                </div>

                <div class="column" style="background-color:<?php echo $_SESSION['mprightcolumn'] ?>;
                    float:left;width:20%;"> <!-- Right Column -->
                    <br>
                    <h2>Automated Meal Plan Info</h2>

                    <?php
                    $tdate = date('Y-m-d', strtotime("+1 day"));
                    $fdate = date('Y-m-d', strtotime("+21 day"));
                    ?>

                    <br>
                    <h5>Starting Date</h5>
                    <input type="date" class="date form-control" name="STARTDATE" min="<?php echo $tdate ?>"
                        max="<?php echo $fdate ?>" style="width: 150px"><br>

                    <h5>Number of Weeks</h5>
                    <input type="number" class="date form-control" name="NOOFWEEKS" min="1" max="4" style="width: 75px">
                    <p>(A maximum of 4 weeks only)</p>

                    <input class="btn btn-primary" type="Submit" name="automatepayment"
                        value="Proceed to Payment"><br><br>

                </div> <!-- Right Column -->
            </div>
        </form>
    </div>
</body>

</html>