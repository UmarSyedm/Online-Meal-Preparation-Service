<!DOCTYPE html>
<html>

<head>
    <title>Employee Reports Page</title>
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
            <a class="active" href="emreports.php"><i class="bi-book"></i>&ensp;Reports</a>
            <a href="emratingacc.php"><i class="bi-star"></i> Rating Accuracy</a>
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
            <div class="row">

                <div class="column" style="width: 20%;padding-top: 10px;">
                    <form method="post">
                        <br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da1"
                                value="Highest Ordered Meals" /><br>
                        </div><br><br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da2"
                                value="Highest Rated Meals" /><br>
                        </div><br><br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da4"
                                value="Highest Revenue Locations" /><br>
                        </div><br><br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da3"
                                value="Users with Highest Orders" /><br>
                        </div><br><br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da5"
                                value="Users with Lowest Orders" /><br>
                        </div><br><br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da6"
                                value="Lowest Ordered Meals" /><br>
                        </div><br><br>
                        <div class="row">
                            <br><input class="btn btn-primary" type="submit" name="da7"
                                value="Lowest Rated Meals" /><br>
                        </div>
                    </form>
                </div>
                <br>
                <!-- <hr class="mb-3"> -->
                <br>
                <div class="column" style="width:80%; padding-top: 5px; padding-left:50px;"><br>

                    <?php if (isset($_POST['da1'])) { ?> <!-- FIRST GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT TITLE, COUNT(*) AS COUNT FROM ORDERS GROUP BY TITLE ORDER BY COUNT DESC LIMIT 10";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown", "red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['TITLE']; ?>");
                                yValues.push("<?php echo $row['COUNT']; ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "horizontalBar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "                                                      Highest Ordered Meals 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
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
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Highest Ordered Meals</h4>

                            <p><b>The highest ordered meals are:</b></p>

                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['TITLE'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- FIRST GRAPH -->

                    <?php if (isset($_POST['da2'])) { ?> <!-- SECOND GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT TITLE, USER_RATING AS RATING, USER_RATING_COUNT FROM FOODS ORDER BY RATING DESC, USER_RATING_COUNT DESC LIMIT 10";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown", "red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['TITLE']; ?>");
                                yValues.push("<?php echo round($row['RATING'], 2); ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "horizontalBar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    animation: {
                                        duration: 2000
                                    },
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "                                     Highest Rated Meals 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
                                            },
                                            color: '#fff',
                                        }
                                    },
                                    borderRadius: 5,
                                    scales: {
                                        xAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Highest Rated Meals</h4>
                            <p><b>The highest rated meals are:</b></p>
                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['TITLE'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- SECOND GRAPH -->

                    <?php if (isset($_POST['da3'])) { ?> <!-- FOURTH GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT USER_NAME, COUNT(*) AS COUNT FROM ORDERS WHERE PAYMENT_STATUS = 'PAID' GROUP BY USER_NAME ORDER BY COUNT DESC LIMIT 5";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown", "red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['USER_NAME']; ?>");
                                yValues.push("<?php echo $row['COUNT']; ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "Users with Highest Orders 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
                                            },
                                            color: '#fff',
                                        }
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Users with Highest Orders</h4>
                            <p><b>The users with highest orders are:</b></p>
                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['USER_NAME'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- FOURTH GRAPH -->


                    <?php if (isset($_POST['da4'])) { ?> <!-- THIRD GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT ADDRESS, SUM(DISCOUNT_COST) AS REVENUE FROM ORDERS WHERE PAYMENT_STATUS = 'PAID' GROUP BY ADDRESS ORDER BY REVENUE DESC LIMIT 5";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['ADDRESS']; ?>");
                                yValues.push("<?php echo $row['REVENUE']; ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "          Highest Revenue Locations 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
                                            },
                                            color: '#fff',
                                        }
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Highest Revenue Locations</h4>
                            <p><b>The locations with highest revenues are:</b></p>
                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['ADDRESS'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- THIRD GRAPH -->

                    <?php if (isset($_POST['da5'])) { ?> <!-- FIFTH GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT USER_NAME, COUNT(*) AS COUNT FROM ORDERS WHERE PAYMENT_STATUS = 'PAID' GROUP BY USER_NAME ORDER BY COUNT ASC LIMIT 5";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown", "red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['USER_NAME']; ?>");
                                yValues.push("<?php echo $row['COUNT']; ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "Users with Lowest Orders 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
                                            },
                                            color: '#fff',
                                        }
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Users with Lowest Orders</h4>
                            <p>The users with lowest orders are:</p>
                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['USER_NAME'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- FIFTH GRAPH -->

                    <?php if (isset($_POST['da6'])) { ?> <!-- SIXTH GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT TITLE, COUNT(*) AS COUNT FROM ORDERS GROUP BY TITLE ORDER BY COUNT ASC LIMIT 10";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown", "red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['TITLE']; ?>");
                                yValues.push("<?php echo $row['COUNT']; ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "horizontalBar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "                                                      Lowest Ordered Meals 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
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
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Lowest Ordered Meals</h4>
                            <p><b>The lowest ordered meals are:</b></p>
                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['TITLE'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- SIXTH GRAPH -->

                    <?php if (isset($_POST['da7'])) { ?> <!-- SEVENTH GRAPH -->

                        <canvas id="myChart" style="padding-left: 100px; width:100%;max-width:900px;"></canvas>

                        <?php
                        $query = "SELECT TITLE, USER_RATING AS RATING, USER_RATING_COUNT FROM FOODS WHERE RATING IS NOT NULL ORDER BY RATING ASC LIMIT 10";
                        $result = $db->query($query);
                        ?>

                        <script>
                            var ctx = document.getElementById('myChart');
                            var barColors = ["red", "green", "blue", "orange", "brown", "red", "green", "blue", "orange", "brown"];
                            xValues = [];
                            yValues = [];

                            <?php
                            while ($row = $result->fetchArray()) {
                                ?>
                                xValues.push("<?php echo $row['TITLE']; ?>");
                                yValues.push("<?php echo round($row['RATING'], 2); ?>");
                                <?php
                            }
                            ?>

                            new Chart(ctx, {
                                type: "horizontalBar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                                options: {
                                    animation: {
                                        duration: 2000
                                    },
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: "                                     Lowest Rated Meals 2023"
                                    },
                                    plugins: {
                                        datalabels: {
                                            align: 'center',
                                            formatter: (value, ctx) => {
                                                return;
                                            },
                                            font: {
                                                weight: 'bold',
                                                size: 15,
                                            },
                                            color: '#fff',
                                        }
                                    },
                                    borderRadius: 5,
                                    scales: {
                                        xAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script><br>

                        <div class="row" style="padding-left:100px; text-align: center;">
                            <h4>Lowest Rated Meals</h4>
                            <p><b>The lowest rated meals are:</b></p>
                            <?php
                            while ($row = $result->fetchArray()) {
                                echo $row['TITLE'] . ',' . ' ';
                            }
                            echo ".";
                            ?>
                        </div>
                    <?php } ?> <!-- SEVENTH GRAPH -->

                </div>
            </div>
        </div>
    </div>
</body>

</html>