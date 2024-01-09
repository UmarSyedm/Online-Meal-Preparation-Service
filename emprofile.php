<!DOCTYPE html>
<html>

<head>
    <title>Employee Profile Page</title>
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
            width: 100%
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script>
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
            <a class="active1" href="emprofile.php" class="split"><i class="bi-person-lines-fill"></i> Site Stats</a>
            <a href="emadd.php"><i class="bi-clipboard-plus"></i> Add Meal</a>
            <a href="emreports.php"><i class="bi-book"></i>&ensp;Reports</a>
            <a href="emratingacc.php"><i class="bi-star"></i> Rating Accuracy</a>
            <a href="emfeedback.php"><i class="bi-star"></i> Feedback</a>
        </nav>
    </div>

    <div class="main2" style="padding-left:16px">

        <div class="container"><br>
            <div class="row">
                <?php
                $db = new SQLite3('database/SMP.db');
                $emusername = $_SESSION['emuser_name'];

                $query = "SELECT * FROM EM_INFO WHERE EMUSER_NAME = '$emusername'";

                $result = $db->query($query);
                ?>

                <!-- <div class="column" style="width: 25%;">
                    <h2>Employee Info</h2><br>
                    <table>
                        <?php
                        //while ($rows = $result->fetchArray()) {
                        ?>
                            <tr>
                                <th style="width:30%">Username</th>
                                <td>
                                    <?php //echo $rows['EMUSER_NAME']; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td>
                                    <?php //echo $rows['EMFIRST_NAME']; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>
                                    <?php //echo $rows['EMLAST_NAME']; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>
                                    <?php //echo $rows['EMPHONE_NUMBER']; ?>
                                </td>
                            </tr>

                            <?php
                            //}
                            ?>
                    </table>
                </div> -->

                <div class="column">

                    <h2 style="text-align: center;">Site Statistics</h2><br>

                    <div class="row">

                        <div class="column" style="width: 40%; padding-top: 60px;">

                            <div style="padding-left:50px;">
                                <table>

                                    <?php
                                    $query = "SELECT COUNT(DISTINCT(USER_NAME)) FROM USER_INFO";
                                    $result = $db->querySingle($query);
                                    ?>
                                    <tr>
                                        <th>Number of Users</th>
                                        <td>
                                            <?php echo $result; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $query = "SELECT COUNT(*) FROM FOODS";
                                    $result = $db->querySingle($query);
                                    ?>
                                    <!-- echo "<p><b>Number of Meals - </b>$result</p>"; -->
                                    <tr>
                                        <th>Number of Meals</th>
                                        <td>
                                            <?php echo $result; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $query = "SELECT COUNT(*) FROM ORDERS
                                    UNION ALL
                                    SELECT COUNT(*) FROM BD_ORDERS";
                                    $result = $db->querySingle($query);
                                    ?>
                                    <!-- echo "<p><b>Number of Orders - </b>$result</p>"; -->
                                    <tr>
                                        <th>Number of Orders</th>
                                        <td>
                                            <?php echo $result; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $query = "SELECT COUNT(*) FROM RATING";
                                    $result = $db->querySingle($query);
                                    ?>
                                    <!-- echo "<p><b>Total Ratings - </b>$result</p>"; -->
                                    <tr>
                                        <th>Total Ratings</th>
                                        <td>
                                            <?php echo $result; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $query = "SELECT COUNT(*) FROM FEEDBACK";
                                    $result = $db->querySingle($query);
                                    ?>
                                    <!-- echo "<p><b>Feedbacks Given - </b>$result</p>"; -->
                                    <tr>
                                        <th>Feedbacks Given</th>
                                        <td>
                                            <?php echo $result; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="column" style="width: 60%;">

                            <canvas id="myChart"
                                style="width: 100%; max-width: 800px; height: 450px; padding-left: 50px;"></canvas>

                            <?php

                            $query = "SELECT MEAL_TYPE FROM FOODS";
                            $result = $db->query($query);

                            $query1 = "SELECT MEAL_TYPE, COUNT(*) FROM FOODS WHERE MEAL_PREF = 'VEG' GROUP BY MEAL_TYPE ORDER BY MEAL_TYPE";
                            $result1 = $db->query($query1);

                            $query2 = "SELECT MEAL_TYPE, COUNT(*) FROM FOODS WHERE MEAL_PREF = 'NONVEG' GROUP BY MEAL_TYPE ORDER BY MEAL_TYPE";
                            $result2 = $db->query($query2);
                            ?>

                            <script>

                                var xValues = ["Breakfast", "Dinner", "Lunch", "Snack"];
                                var y1Values = [];
                                var y2Values = [];
                                var bar1Colors = ["orange", "orange", "orange", "orange"];
                                var bar2Colors = ["salmon", "salmon", "salmon", "salmon"];

                                <?php
                                while ($row1 = $result1->fetchArray()) {
                                    ?>
                                    y1Values.push("<?php echo $row1['COUNT(*)']; ?>");
                                    <?php
                                }
                                ?>
                                <?php
                                while ($row2 = $result2->fetchArray()) {
                                    ?>
                                    y2Values.push("<?php echo $row2['COUNT(*)']; ?>");
                                    <?php
                                }
                                ?>

                                new Chart("myChart", {
                                    type: "bar",
                                    data: {
                                        labels: xValues,
                                        datasets: [
                                            {
                                                label: "Veg",
                                                backgroundColor: bar1Colors,
                                                data: y1Values
                                            },
                                            {
                                                label: "Nonveg",
                                                backgroundColor: bar2Colors,
                                                data: y2Values
                                            }
                                        ]
                                    },
                                    options: {
                                        legend: { display: true },
                                        title: {
                                            display: true,
                                            text: "List of Meal Types"
                                        },
                                        plugins: {
                                            datalabels: {
                                                align: 'center',
                                                formatter: (value, ctx) => {
                                                    return;
                                                },
                                                font: {
                                                    weight: 'bold',
                                                    size: 12,
                                                },
                                                color: '#fff',
                                            }
                                        },
                                        /* scales: {
                                            xAxes: [{
                                                ticks: {
                                                    beginAtZero: true,
                                                }
                                            }]
                                        } */
                                        scales: {
                                            xAxes: [{
                                                stacked: true
                                            }],
                                            yAxes: [{
                                                stacked: true
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>