<!DOCTYPE html>
<html>

<head>
    <title>Employee Rating Accuracy Page</title>
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
            width: 90%;
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
    <?php
    session_start();
    $db = new SQLite3('database/SMP.db');
    ?>

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
            <a class="active" href="emratingacc.php"><i class="bi-star"></i> Rating Accuracy</a>
            <a href="emfeedback.php"><i class="bi-star"></i> Feedback</a>
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

        <div class="container">
            <br>
            <!-- <h2>Statistics Page</h2><br> -->

            <div class="row">

                <div class="column" style="width: 45%; padding-top: 10px;">

                    <?php

                    $query = "SELECT TITLE, MEAL_TYPE, USER_RATING, ML_RATING, 
                                ROUND(ABS(USER_RATING - ML_RATING), 2) AS VARIANCE 
                                FROM FOODS WHERE ML_RATING IS NOT '-1' ORDER BY VARIANCE DESC LIMIT 5";

                    $result = $db->query($query);
                    ?>

                    <br>
                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Meal Type</th>
                            <th>User Rating</th>
                            <th>ML Rating</th>
                            <th>Variance</th>
                        </tr>
                        <?php
                        while ($row = $result->fetchArray()) {
                            ?>
                            <td>
                                <b>
                                    <?php echo $row[0]; ?>
                                </b>
                            </td>
                            <td>
                                <?php echo $row[1]; ?>
                            </td>
                            <td>
                                <?php echo $row[2]; ?>
                            </td>
                            <td>
                                <?php echo $row[3]; ?>
                            </td>
                            <td>
                                <b>
                                    <?php echo $row[4]; ?>
                                </b>
                            </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>

                <div class="column" style="width: 55%;">
                    <!-- <p>Graph</p> -->

                    <canvas id="myChart"
                        style="width: 100%; max-width: 600px; height: 400px; padding-left: 30px;"></canvas>

                    <?php

                    $query = "SELECT TITLE, MEAL_TYPE, USER_RATING, ML_RATING, 
                                ROUND(ABS(USER_RATING - ML_RATING), 2) AS VARIANCE 
                                FROM FOODS WHERE ML_RATING IS NOT '-1' ORDER BY VARIANCE DESC LIMIT 5";
                    $result = $db->query($query);
                    ?>

                    <script>

                        var xValues = [];
                        var y1Values = [];
                        var y2Values = [];
                        var bar1Colors = ["red", "green", "blue", "orange", "brown"];
                        var bar2Colors = ["brown", "orange", "blue", "green", "red"];

                        <?php
                        while ($row = $result->fetchArray()) {
                            ?>
                            xValues.push("<?php echo $row['TITLE']; ?>");
                            y1Values.push("<?php echo $row['USER_RATING']; ?>");
                            y2Values.push("<?php echo $row['ML_RATING']; ?>");
                            <?php
                        }
                        ?>

                        new Chart("myChart", {
                            type: "horizontalBar",
                            data: {
                                labels: xValues,
                                datasets: [
                                    {
                                        backgroundColor: bar1Colors,
                                        data: y1Values
                                    },
                                    {
                                        backgroundColor: bar2Colors,
                                        data: y2Values
                                    }
                                ]
                            },
                            options: {
                                legend: { display: false },
                                title: {
                                    display: true,
                                    text: "                       List of New Meals 2023"
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
                                scales: {
                                    xAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                        }
                                    }]
                                }
                            }
                        });
                    </script>

                    <br><br>
                    <p style="padding-left: 40px;">Comparison between User Rating Vs Rating calculated by the
                        Algorithm (Cosine Similarity). Lower Variance depicts Higher Accuracy of the Algorithm and
                        Vice-Versa.</p>

                </div>
            </div>
        </div>
    </div>
</body>

</html>