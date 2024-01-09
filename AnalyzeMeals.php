<!DOCTYPE html>
<html>

<head>
    <title>Analyze Meals Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script>
</head>
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
            <a class="active" href="AnalyzeMeals.php"><i class="bi-cup-straw"></i> Analyze Meals</a>
            <a href="Profile.php" class="split"><i class="bi-person-lines-fill"></i> Profile</a>
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

    <?php $db = new SQLite3('database/SMP.db'); ?>

    <div class="main2" style="padding-left:0px;padding-right:0px;">

        <?php
        if (isset($_POST['submit'])) {

            $bfmeal = $_POST['BFMeals'];
            $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$bfmeal'";
            $bfresult = $db->query($query);
            $bfrow = $bfresult->fetchArray();

            $lnmeal = $_POST['LNMeals'];
            $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$lnmeal'";
            $lnresult = $db->query($query);
            $lnrow = $lnresult->fetchArray();

            $snmeal = $_POST['SNMeals'];
            $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$snmeal'";
            $snresult = $db->query($query);
            $snrow = $snresult->fetchArray();

            $dnmeal = $_POST['DNMeals'];
            $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$dnmeal'";
            $dnresult = $db->query($query);
            $dnrow = $dnresult->fetchArray();

        } ?>

        <div class="container">

            <form action="" method="post"><br>

                <div class="row" style="padding-top: 15px;">

                    <div class="column" style="width: 24%;">

                        <?php

                        $username = $_SESSION['user_name'];

                        if ($_SESSION['mealpref'] == 'VEG') {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'BF' AND MEAL_PREF = 
                                        (SELECT MEAL_PREF FROM USER_INFO WHERE USER_NAME = '$username') ORDER BY TITLE";
                            $result = $db->query($query);
                        } else {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'BF' ORDER BY TITLE";
                            $result = $db->query($query);
                        }

                        ?>

                        <label for="bfmeals">
                            <h4><b>Breakfast Meals:</b></h4>
                        </label><br><br>
                        <select id="bfmeals" name="BFMeals" required><br>
                            <option value="">Select a Breakfast Meal:</option>

                            <?php while ($row = $result->fetchArray()) {

                                if ($bfmeal == $row[0]) {
                                    echo "<option value='$row[0]' selected>$row[0]</option>";
                                } else {
                                    echo "<option value='$row[0]'>$row[0]</option>";
                                }
                            } ?>
                        </select>

                    </div>

                    <div class="column" style="width: 24%;">

                        <?php

                        if ($_SESSION['mealpref'] == 'VEG') {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'LN' AND MEAL_PREF = 
                                        (SELECT MEAL_PREF FROM USER_INFO WHERE USER_NAME = '$username') ORDER BY TITLE";
                            $result = $db->query($query);
                        } else {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'LN' ORDER BY TITLE";
                            $result = $db->query($query);
                        }

                        ?>

                        <label for="lnmeals">
                            <h4><strong>Lunch Meals:</strong></h4>
                        </label><br><br>
                        <select id="lnmeals" name="LNMeals" required><br>
                            <option value="">Select a Lunch Meal:</option>

                            <?php while ($row = $result->fetchArray()) {

                                if ($lnmeal == $row[0]) {
                                    echo "<option value='$row[0]' selected>$row[0]</option>";
                                } else {
                                    echo "<option value='$row[0]'>$row[0]</option>";
                                }
                            } ?>
                        </select>

                    </div>

                    <div class="column" style="width: 24%;">

                        <?php

                        if ($_SESSION['mealpref'] == 'VEG') {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'SN' AND MEAL_PREF = 
                                        (SELECT MEAL_PREF FROM USER_INFO WHERE USER_NAME = '$username') ORDER BY TITLE";
                            $result = $db->query($query);
                        } else {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'SN' ORDER BY TITLE";
                            $result = $db->query($query);
                        }

                        ?>

                        <label for="snmeals">
                            <h4><b>Snack Meals:</b></h4>
                        </label><br><br>
                        <select id="snmeals" name="SNMeals" required><br>
                            <option value="">Select a Snack Meal:</option>

                            <?php while ($row = $result->fetchArray()) {

                                if ($snmeal == $row[0]) {
                                    echo "<option value='$row[0]' selected>$row[0]</option>";
                                } else {
                                    echo "<option value='$row[0]'>$row[0]</option>";
                                }
                            } ?>
                        </select>

                    </div>

                    <div class="column" style="width: 24%;">

                        <?php

                        if ($_SESSION['mealpref'] == 'VEG') {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'DN' AND MEAL_PREF = 
                                        (SELECT MEAL_PREF FROM USER_INFO WHERE USER_NAME = '$username') ORDER BY TITLE";
                            $result = $db->query($query);
                        } else {
                            $query = "SELECT TITLE FROM FOODS WHERE MEAL_TYPE = 'DN' ORDER BY TITLE";
                            $result = $db->query($query);
                        }

                        ?>

                        <label for="dnmeals">
                            <h4><b>Dinner Meals:</b></h4>
                        </label><br><br>
                        <select id="dnmeals" name="DNMeals" required><br>
                            <option value="">Select a Dinner Meal:</option>

                            <?php while ($row = $result->fetchArray()) {

                                if ($dnmeal == $row[0]) {
                                    echo "<option value='$row[0]' selected>$row[0]</option>";
                                } else {
                                    echo "<option value='$row[0]'>$row[0]</option>";
                                }
                            } ?>
                        </select>

                    </div>

                    <div class="column" style="width: 4%;"><br><br>

                        <input class="btn btn-primary" style="align: right;" type="submit" name="submit" value="Submit">

                    </div>
                </div>
            </form>
        </div>

        <br>
        <hr class="mb-3">


        <?php
        // if (isset($_POST['submit'])) { ?>

        <?php if ($bfmeal) {

            ?>

            <div class='row' style='width:100%;'>

                <div class='column' style='width: 40%; padding-top: 10px; height: 440px;'>
                    <!-- Left Column -->

                    <?php
                    // $bfmeal = $_POST['BFMeals'];
                    // $_SESSION['bfmealvar'] = $bfmeal;
                    // $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$bfmeal'";
                    // $bfresult = $db->query($query);
                    // $bfrow = $bfresult->fetchArray();
                
                    // $lnmeal = $_POST['LNMeals'];
                    // $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$lnmeal'";
                    // $lnresult = $db->query($query);
                    // $lnrow = $lnresult->fetchArray();
                
                    // $snmeal = $_POST['SNMeals'];
                    // $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$snmeal'";
                    // $snresult = $db->query($query);
                    // $snrow = $snresult->fetchArray();
                
                    // $dnmeal = $_POST['DNMeals'];
                    // $query = "SELECT TITLE, CARBS, PROTEIN, FAT FROM FOODS WHERE TITLE = '$dnmeal'";
                    // $dnresult = $db->query($query);
                    // $dnrow = $dnresult->fetchArray();
                
                    ?>

                    <h4 style="text-align: center;"><b>Nutrient Info</b></h4><br>

                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Carbs</th>
                            <th>Protein</th>
                            <th>Fat</th>
                        </tr>
                        <tr>
                            <td><b>
                                    <?php echo $bfrow[0]; ?>
                                </b></td>
                            <td>
                                <?php echo $bfrow[1]; ?>
                            </td>
                            <td>
                                <?php echo $bfrow[2]; ?>
                            </td>
                            <td>
                                <?php echo $bfrow[3]; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>
                                    <?php echo $lnrow[0]; ?>
                                </b></td>
                            <td>
                                <?php echo $lnrow[1]; ?>
                            </td>
                            <td>
                                <?php echo $lnrow[2]; ?>
                            </td>
                            <td>
                                <?php echo $lnrow[3]; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>
                                    <?php echo $snrow[0]; ?>
                                </b></td>
                            <td>
                                <?php echo $snrow[1]; ?>
                            </td>
                            <td>
                                <?php echo $snrow[2]; ?>
                            </td>
                            <td>
                                <?php echo $snrow[3]; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>
                                    <?php echo $dnrow[0]; ?>
                                </b></td>
                            <td>
                                <?php echo $dnrow[1]; ?>
                            </td>
                            <td>
                                <?php echo $dnrow[2]; ?>
                            </td>
                            <td>
                                <?php echo $dnrow[3]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><b>
                                    <?php echo $bfrow[1] + $lnrow[1] + $snrow[1] + $dnrow[1]; ?> g
                                </b></td>
                            <td><b>
                                    <?php echo $bfrow[2] + $lnrow[2] + $snrow[2] + $dnrow[2]; ?> g
                                </b></td>
                            <td><b>
                                    <?php echo $bfrow[3] + $lnrow[3] + $snrow[3] + $dnrow[3]; ?> g
                                </b></td>
                        </tr>
                    </table>
                </div> <!-- Left Column -->

                <div class="column" style="width: 32%; padding-top: 10px; height: 440px;">
                    <!-- Center Column -->

                    <h4 style="text-align: center; padding-bottom: 15px;"><b>Nutrient Ratio</b></h4>

                    <?php
                    $carbscal = $bfrow[1] * 4 + $lnrow[1] * 4 + $snrow[1] * 4 + $dnrow[1] * 4;
                    $proteincal = $bfrow[2] * 4 + $lnrow[2] * 4 + $snrow[2] * 4 + $dnrow[2] * 4;
                    $fatcal = $bfrow[3] * 9 + $lnrow[3] * 9 + $snrow[3] * 9 + $dnrow[3] * 9;
                    $totalcal = $carbscal + $proteincal + $fatcal;
                    ?>

                    <canvas id="myChart" style="width:100%; max-width: 1000px; height: 330px;"></canvas>

                    <script>
                        var ctx = document.getElementById('myChart');
                        var xValues = ["Carbs", "Protein", "Fat"];
                        var yValues = [<?php echo round(($carbscal / $totalcal) * 100, 2); ?>, <?php echo round(($proteincal / $totalcal) * 100, 2); ?>, <?php echo round(($fatcal / $totalcal) * 100, 2); ?>];
                        var barColors = [
                            "#b91d47",
                            // "#00aba9",
                            "#e8c3b9",
                            "#2b5797",
                            "#e8c3b9",
                            "#1e7145"
                        ];

                        new Chart(ctx, {
                            type: "pie",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: "For a Balanced Diet - (Carbs: 62%, Protein: 13%, Fat: 25%)"
                                },
                                plugins: {
                                    datalabels: {
                                        align: 'center',
                                        formatter: (value, ctx) => {
                                            return;
                                        },
                                        font: {
                                            weight: 'bold',
                                            size: 13,
                                        },
                                        color: '#fff',
                                    }
                                }
                            }
                        });
                    </script>

                </div> <!-- Center Column -->

                <div class="column" style="width: 28%; padding-top: 10px; height: 440px;">
                    <!-- Right Column -->

                    <!-- To put: 
                            User's Target Calories, Balanced Diet Ratio
                            Chosen Calories, Chosen Ratio, Chosen Variance
                    -->

                    <?php
                    $username = $_SESSION['user_name'];

                    $query = "SELECT TARGET_CAL FROM USER_INFO WHERE USER_NAME = '$username'";
                    $result = $db->querySingle($query);
                    ?>

                    <?php
                    $variance = abs((round(($carbscal / $totalcal) * 100, 2) - 62)) +
                        abs((round(($proteincal / $totalcal) * 100, 2) - 13)) +
                        abs((round(($fatcal / $totalcal) * 100, 2)) - 25);
                    ?>

                    <h4 style="text-align: center;"><b>Analysis</b></h4><br>

                    <p><b>User's Target Calories - </b>
                        <?php echo round($result, 0); ?> KCal
                    </p>
                    <p><b>Balanced Ratio - </b>Carbs: <b>62%</b>, Protein: <b>13%</b>, Fat: <b>25%</b></p><br>
                    <p><b>Chosen Calories - </b>
                        <?php echo $totalcal; ?> KCal
                    </p>

                    <p><b>Chosen Ratio - </b>Carbs: <b>
                            <?php echo round(($carbscal / $totalcal) * 100, 0) ?>%
                        </b>,
                        Protein: <b>
                            <?php echo round(($proteincal / $totalcal) * 100, 0); ?>%
                        </b>,
                        Fat: <b>
                            <?php echo round(($fatcal / $totalcal) * 100, 0); ?>%
                        </b></p>

                    <p><b>Chosen Variance - </b>
                        <?php echo round($variance, 2); ?>%
                    </p>
                    <p>Variance value shows the Deviation between your selected set of meals and the Balanced Diet Ratio.
                    </p>
                    <!-- <p>Chosen Variance value should be lower than 4 to acquire a good Balanced Diet.</p> -->
                    <p style="color: <?php echo $_SESSION["bodytheme"] ?>;"><b>Use our automate Balanced Diet tool to
                            generate a Balanced Diet prescribed to you.</b></p>


                </div> <!-- Right Column -->
            </div>
        <?php } ?>
    </div> <!-- For Main -->
</body>

</html>