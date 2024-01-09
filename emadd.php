<!DOCTYPE html>
<html>

<head>
    <title>Employee Add Meal Page</title>
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
            <a class="active" href="emadd.php"><i class="bi-clipboard-plus"></i> Add Meal</a>
            <a href="emreports.php"><i class="bi-book"></i>&ensp;Reports</a>
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

        <div>
            <form action="emadd.php" method="post">
                <div class="container" style="padding-top: 20px;">

                    <h1>Add Meal</h1>
                    <p>Fill up the form with correct values.</p>

                    <div class="row">
                        <div class="col">

                            <p><label for="TITLE"><b>Title</b></label>
                                <input class="form-control" placeholder="Enter Title of Meal" type="text" name="TITLE"
                                    required autofocus>
                            </p>

                            <p><label for="CALORIES"><b>Calories</b></label>
                                <input class="form-control" placeholder="Enter Calories" type="integer" name="CALORIES"
                                    required>
                            </p>

                            <p><label for="CARBS"><b>Carbohydrates</b></label>
                                <input class="form-control" placeholder="Enter Carbohydrates in g" type="real"
                                    name="CARBS" required>
                            </p>

                            <p><label for="PROTEIN"><b>Protein</b></label>
                                <input class="form-control" placeholder="Enter Protein in g" type="real" name="PROTEIN"
                                    required>
                            </p>

                            <p><label for="FAT"><b>Fat</b></label>
                                <input class="form-control" placeholder="Enter Fat in g" type="real" name="FAT"
                                    required>
                            </p>

                        </div>

                        <div class="col">

                            <p><label for="SUGAR"><b>Sugar</b></label>
                                <input class="form-control" placeholder="Enter Sugar in g" type="real" name="SUGAR"
                                    required>
                            </p>

                            <p><label for="FIBER"><b>Fiber</b></label>
                                <input class="form-control" placeholder="Enter Fiber in g" type="real" name="FIBER"
                                    required>
                            </p>

                            <p><label for="SODIUM"><b>Sodium</b></label>
                                <input class="form-control" placeholder="Enter Sodium in mg" type="real" name="SODIUM"
                                    required>
                            </p>

                            <p><label for="COST1"><b>Cost</b></label>
                                <input class="form-control" placeholder="Enter Cost" type="real" name="COST1" required>
                            </p>
                            <p>
                                <label style="padding-bottom:6px;" for="MEAL_PREF"><b>Meal Type</b></label><br>
                                <input type="radio" name="MEAL_PREF" value="VEG" required>
                                <label for="VEG">Veg &emsp;</label>
                                <input type="radio" name="MEAL_PREF" value="NONVEG" required>
                                <label for="NONVEG">Non Veg</label>
                            </p>

                        </div>

                        <div class="col">

                            <p>
                                <label style="padding-bottom:6px;" for="MEAL_TYPE"><b>Meal Time</b></label><br>
                                <input type="radio" name="MEAL_TYPE" value="BF" required>
                                <label for="BF">BF &emsp;</label>
                                <input type="radio" name="MEAL_TYPE" value="LN" required>
                                <label for="LN">LN &emsp;</label>
                                <input type="radio" name="MEAL_TYPE" value="DN" required>
                                <label for="DN">DN</label>
                            </p>

                            <p>
                                <label style="padding-bottom:6px;" for="BMI_CLASS"><b>BMI Class</b></label><br>
                                <input type="radio" name="BMI_CLASS" value="UW" required>
                                <label for="UW">UW &emsp;</label>
                                <input type="radio" name="BMI_CLASS" value="MW" required>
                                <label for="MW">MW &emsp;</label>
                                <input type="radio" name="BMI_CLASS" value="OW" required>
                                <label for="OW">OW</label>
                            </p>

                        </div>

                        <hr class="mb-3">

                    </div>

                    <!-- <p><input type="checkbox" id="exampleCheck" required>
                        <label for="exampleCheck">Agree to our <a href="#">Terms & Privacy</a>.</label>
                    </p> -->

                    <input class="btn btn-primary" type="submit" name="add" value="Add Meal">

                </div>
            </form>

        </div>

    </div>

    <div>
        <?php
        if (isset($_POST['add'])) {

            $title = $_POST['TITLE'];
            $calories = $_POST['CALORIES'];
            $carbs = $_POST['CARBS'];
            $protein = $_POST['PROTEIN'];
            $fat = $_POST['FAT'];
            $sugar = $_POST['SUGAR'];
            $fiber = $_POST['FIBER'];
            $sodium = $_POST['SODIUM'];
            $cost = $_POST['COST1'];
            $mealpref = $_POST['MEAL_PREF'];
            $mealtype = $_POST['MEAL_TYPE'];
            $bmiclass = $_POST['BMI_CLASS'];

            $db = new SQLite3('database/SMP.db');

            $query = $db->exec("INSERT INTO FOODS(TITLE, CALORIES, CARBS, PROTEIN, FAT, SUGAR, FIBER, SODIUM, COST1, MEAL_PREF, MEAL_TYPE, BMI_CLASS) 
                VALUES('$title', '$calories', '$carbs', '$protein', '$fat', '$sugar', '$fiber', '$sodium', '$cost', '$mealpref', '$mealtype', '$bmiclass')");

            $result = $db->query($query);

            $command = escapeshellcmd('python ML_Cosine.py');
            $output = exec($command);

            $command = escapeshellcmd('python ML_CS_Meals.py');
            $output = exec($command);

            $command = escapeshellcmd('python BD_Groups.py');
            $output = exec($command);
        }
        ?>
    </div>
    </div>
</body>

</html>