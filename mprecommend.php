<!DOCTYPE html>
<html>

<head>
    <title>Automate Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">
    <link rel="stylesheet" href="mprecommend.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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

        <?php

        $tickedquery = "SELECT USER_NAME, TITLE FROM ML_BD_CHECKED WHERE USER_NAME = '$username'";
        $tickedresult = $db->query($tickedquery);
        $tickedtitles = array();

        while ($tickedrow = $tickedresult->fetchArray()) {
            $tickedtitles[] = $tickedrow[1];
        }
        ?>

        <form action="" method="post">

            <div class="row"> <!-- Row -->

                <div class="column" style="width:80%; background-color:<?php echo $_SESSION['bodytheme'] ?>;">
                    <!-- Left Column -->
                    <br>

                    <div class="row">

                        <div class="col">

                            <?php
                            for ($x = 1; $x <= 9; $x += 2) {
                                ?>
                                <div class="row">

                                    <script>
                                        $(document).ready(function () {
                                            $("#checkedAll<?php echo $x; ?>").change(function () {
                                                if (this.checked) {
                                                    $(".checkSingle<?php echo $x; ?>").each(function () {
                                                        this.checked = true;
                                                    })
                                                } else {
                                                    $(".checkSingle<?php echo $x; ?>").each(function () {
                                                        this.checked = false;
                                                    })
                                                }
                                            });
                                        });
                                    </script>

                                    <?php

                                    $query = "SELECT MEAL_TYPE, TITLE, CALORIES, CARBS, PROTEIN, FAT, DAY_INDEX, RANK 
                                                FROM BD_GROUPS
                                                WHERE USER_NAME = '$username'
                                                ORDER BY RANK DESC, DAY_INDEX ASC
                                                LIMIT ($x-1)*4, 4";

                                    $result = $db->query($query);

                                    ?>

                                    <div class="mealbox">

                                        <?php
                                        while ($row = $result->fetchArray()) {
                                            $val = $row['TITLE'];
                                        }
                                        if (in_array($val, $tickedtitles)) {
                                            ?>
                                            <h3><input type="checkbox" class="checkboxes" name="checkedAll<?php echo $x; ?>"
                                                    id="checkedAll<?php echo $x; ?>" checked>
                                                Option - <?php echo $x; ?></h3>
                                            <?php
                                        } else {
                                            ?>
                                            <h3><input type="checkbox" class="checkboxes" name="checkedAll<?php echo $x; ?>"
                                                    id="checkedAll<?php echo $x; ?>">
                                                Option - <?php echo $x; ?></h3>
                                            <?php
                                        }
                                        ?>

                                        <div class="mealtable">
                                            <div class="vertical-menu">
                                                <div class="row" style="width:100%;">
                                                    <table>
                                                        <tr>
                                                            <th style="width:80px;">Select</th>
                                                            <th style="width:280px;">Title</th>
                                                            <th style="width:82px;">Meal</th>
                                                            <th style="width:82px;">Calories</th>
                                                            <th style="width:82px;">Carbs</th>
                                                            <th style="width:80px;">Protein</th>
                                                            <th style="width:80px;">Fat</th>
                                                        </tr>

                                                        <?php

                                                        while ($rows = $result->fetchArray()) {
                                                            ?>
                                                            <td>
                                                                <?php
                                                                if (in_array($rows['TITLE'], $tickedtitles)) {
                                                                    ?>
                                                                    <input style="align:center;"
                                                                        class="checkSingle<?php echo $x; ?>" type="checkbox"
                                                                        name="checkArr[]" value="<?php echo $rows['TITLE']; ?>"
                                                                        onclick="return false;" checked>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <input style="align:center;"
                                                                        class="checkSingle<?php echo $x; ?>" type="checkbox"
                                                                        name="checkArr[]" value="<?php echo $rows['TITLE']; ?>"
                                                                        onclick="return false;">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rows['TITLE']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rows['MEAL_TYPE']; ?>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="col">

                            <?php
                            for ($x = 2; $x <= 10; $x += 2) {
                                ?>

                                <div class="row">

                                    <script>
                                        $(document).ready(function () {
                                            $("#checkedAll<?php echo $x; ?>").change(function () {
                                                if (this.checked) {
                                                    $(".checkSingle<?php echo $x; ?>").each(function () {
                                                        this.checked = true;
                                                    })
                                                } else {
                                                    $(".checkSingle<?php echo $x; ?>").each(function () {
                                                        this.checked = false;
                                                    })
                                                }
                                            });
                                        });
                                    </script>

                                    <?php

                                    $query = "SELECT MEAL_TYPE, TITLE, CALORIES, CARBS, PROTEIN, FAT, DAY_INDEX, RANK 
                                                FROM BD_GROUPS
                                                WHERE USER_NAME = '$username'
                                                ORDER BY RANK DESC, DAY_INDEX ASC
                                                LIMIT ($x-1)*4, 4";

                                    $result = $db->query($query);
                                    ?>

                                    <div class="mealbox">

                                        <?php
                                        while ($row = $result->fetchArray()) {
                                            $val = $row['TITLE'];
                                        }
                                        if (in_array($val, $tickedtitles)) {
                                            ?>
                                            <h3><input type="checkbox" class="checkboxes" name="checkedAll<?php echo $x; ?>"
                                                    id="checkedAll<?php echo $x; ?>" checked>
                                                Option - <?php echo $x; ?></h3>
                                            <?php
                                        } else {
                                            ?>
                                            <h3><input type="checkbox" class="checkboxes" name="checkedAll<?php echo $x; ?>"
                                                    id="checkedAll<?php echo $x; ?>">
                                                Option - <?php echo $x; ?></h3>
                                            <?php
                                        }
                                        ?>

                                        <div class="mealtable">
                                            <div class="vertical-menu">
                                                <div class="row" style="width:100%;">
                                                    <table>
                                                        <tr>
                                                            <th style="width:80px;">Select</th>
                                                            <th style="width:280px;">Title</th>
                                                            <th style="width:82px;">Meal</th>
                                                            <th style="width:82px;">Calories</th>
                                                            <th style="width:82px;">Carbs</th>
                                                            <th style="width:80px;">Protein</th>
                                                            <th style="width:80px;">Fat</th>
                                                        </tr>

                                                        <?php
                                                        while ($rows = $result->fetchArray()) {
                                                            ?>
                                                            <td>
                                                                <?php
                                                                if (in_array($rows['TITLE'], $tickedtitles)) {
                                                                    ?>
                                                                    <input style="align:center;"
                                                                        class="checkSingle<?php echo $x; ?>" type="checkbox"
                                                                        name="checkArr[]" value="<?php echo $rows['TITLE']; ?>"
                                                                        onclick="return false;" checked>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <input style="align:center;"
                                                                        class="checkSingle<?php echo $x; ?>" type="checkbox"
                                                                        name="checkArr[]" value="<?php echo $rows['TITLE']; ?>"
                                                                        onclick="return false;">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rows['TITLE']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rows['MEAL_TYPE']; ?>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div>

                        <?php

                        $_SESSION['PAY_ID'] = rand(1000, 9999);

                        if (isset($_POST['recalculate'])) {

                            if (!empty($_POST['checkArr'])) {

                                $optioncount = count($_POST['checkArr']);

                                $query = "SELECT MEAL_TYPE, TITLE, CALORIES, CARBS, PROTEIN, FAT, DAY_INDEX, RANK 
                                            FROM BD_GROUPS
                                            WHERE USER_NAME = '$username'
                                            ORDER BY RANK DESC, DAY_INDEX ASC
                                            LIMIT 0, 40";

                                $result = $db->query($query);

                                $checkedtitles = $_POST['checkArr'];

                                while ($title = $result->fetchArray()) {

                                    $rank = (in_array($title[1], $checkedtitles) ? 1 : -1);

                                    $updatequery = "UPDATE BD_GROUPS SET RANK = RANK + $rank WHERE TITLE = '$title[1]'
                                                    AND USER_NAME = '$username'";
                                    $updateresult = $db->query($updatequery);
                                }

                                $cstitlequery = "UPDATE BD_GROUPS SET RANK = RANK + 1 WHERE USER_NAME = '$username' AND TITLE IN (SELECT TITLE FROM BD_GROUPS
                                                    WHERE USER_NAME = '$username' AND DAY_INDEX IN (SELECT DAY_INDEX FROM BD_GROUPS 
                                                    WHERE USER_NAME = '$username' AND TITLE IN (SELECT CS_TITLE FROM FOODS 
                                                    WHERE TITLE IN ('" . implode("', '", $checkedtitles) . "'))))";

                                $cstitleresult = $db->query($cstitlequery);

                                $db->exec("DELETE FROM ML_BD_CHECKED WHERE USER_NAME = '$username'");

                                foreach ($checkedtitles as $title) {
                                    $db->exec("INSERT INTO ML_BD_CHECKED (USER_NAME, TITLE, CHECKED) VALUES ('$username', '$title', 'YES')");
                                }
                            }
                            echo "<script>location.href = 'mprecommend.php'</script>";
                        }

                        if (isset($_POST['reset'])) {

                            $db->exec("UPDATE BD_GROUPS SET RANK = '0' WHERE USER_NAME = '$username'");
                            $db->exec("DELETE FROM ML_BD_CHECKED WHERE USER_NAME = '$username'");

                            echo "<script>location.href = 'mprecommend.php'</script>";

                        }

                        if (isset($_POST['recommendpayment'])) {

                            if (!empty($_POST['checkArr'])) {

                                $query = "SELECT MEAL_TYPE, TITLE, CALORIES, CARBS, PROTEIN, FAT, DAY_INDEX, RANK 
                                            FROM BD_GROUPS
                                            WHERE USER_NAME = '$username'
                                            ORDER BY RANK DESC, DAY_INDEX ASC
                                            LIMIT 0, 40";

                                $result = $db->query($query);

                                $checkedtitles = $_POST['checkArr'];

                                while ($title = $result->fetchArray()) {

                                    $rank = (in_array($title[1], $checkedtitles) ? 1 : -1);

                                    $updatequery = "UPDATE BD_GROUPS SET RANK = RANK + $rank WHERE TITLE = '$title[1]'
                                                    AND USER_NAME = '$username'";
                                    $updateresult = $db->query($updatequery);
                                }

                                $cstitlequery = "UPDATE BD_GROUPS SET RANK = RANK + 1 WHERE USER_NAME = '$username' AND TITLE IN (SELECT TITLE FROM BD_GROUPS
                                                    WHERE USER_NAME = '$username' AND DAY_INDEX IN (SELECT DAY_INDEX FROM BD_GROUPS 
                                                    WHERE USER_NAME = '$username' AND TITLE IN (SELECT CS_TITLE FROM FOODS 
                                                    WHERE TITLE IN ('" . implode("', '", $checkedtitles) . "'))))";

                                $cstitleresult = $db->query($cstitlequery);

                                $startdate = $_POST['STARTDATE'];
                                $noofcycles = $_POST['NOOFCYCLES'];
                                $payid = $_SESSION['PAY_ID'];
                                $daycount = -1;

                                for ($i = 0; $i < ($noofcycles); $i++) {
                                    foreach ($checkedtitles as $title) {

                                        $query = "SELECT MEAL_TYPE FROM FOODS WHERE TITLE = '$title'";
                                        $mealtype = $db->querySingle($query);

                                        if ($mealtype == 'BF') {
                                            $daycount = $daycount + 1;
                                        }

                                        $deliverydate = date('Y-m-d', strtotime("+$daycount day", strtotime($startdate)));

                                        $insertresult = $db->exec("INSERT INTO BD_ORDERS (USER_NAME, TITLE, MEAL_TYPE, DELIVERY_DATE, PAY_ID) 
                                        VALUES ('$username', '$title', '$mealtype', '$deliverydate', '$payid')");
                                    }
                                }
                                echo "<script>location.href = 'mprecpayment.php'</script>";
                            }
                        }
                        ?>

                    </div>
                </div>

                <div class="column" style="background-color:<?php echo $_SESSION['mprightcolumn'] ?>;
                    float:left;width:20%;"> <!-- Right Column -->
                    <br>
                    <h2>Recommended Meal Plan Info</h2><br>

                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary" type="Submit" name="recalculate" value="Re - Evaluate"
                                formnovalidate>
                            <p style="padding-top: 10px;"><b>Click to get refreshed results!</b></p>
                        </div>
                        <div class="col">
                            <input class="btn btn-primary" type="Submit" name="reset" value="Reset" formnovalidate>
                            <p style="padding-top: 10px;"><b>Click here to restart your journey!</b></p>
                        </div>
                    </div>

                    <?php
                    $tdate = date('Y-m-d', strtotime("+1 day"));
                    $fdate = date('Y-m-d', strtotime("+21 day"));
                    ?>

                    <br>
                    <h5>Starting Date</h5>
                    <input type="date" class="date form-control" name="STARTDATE" min="<?php echo $tdate ?>"
                        max="<?php echo $fdate ?>" style="width: 150px" required><br>

                    <h5>Number of Cycles</h5>
                    <input type="number" class="date form-control" name="NOOFCYCLES" min="1" max="4" style="width: 75px"
                        required>
                    <p>(A maximum of 4 cycles only)</p>

                    <input class="btn btn-primary" type="Submit" name="recommendpayment" value="Proceed to Payment"><br>

                </div> <!-- Right Column -->
            </div>
        </form>
    </div>
</body>

</html>