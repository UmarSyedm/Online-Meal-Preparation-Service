<!DOCTYPE html>
<html>

<head>
    <title>Employee Login Page</title>
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
            <div class="col">
                <h1><a style="text-decoration:none;color:black;" href="index.php">Smart Meal Planner</a></h1>
            </div>
            <div class="col">
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
            <!-- <a href="emprofile.php" class="split"><i class="bi-person-lines-fill"></i> Profile</a> -->
        </nav>
    </div>

    <div class="main2" style="padding-left:16px">

        <div>
            <form method="post">
                <div class="container">

                    <div class="row">

                        <div class="col">
                            <br>
                            <h1>Employee Login</h1>
                            <p>Enter your details.</p>
                            <p><label for="EMUSER_NAME"><b>User Name</b></label>
                                <input class="form-control" placeholder="Enter Username" type="text" name="EMUSER_NAME"
                                    required autofocus>
                            </p>

                            <p><label for="EMPASSWORD"><b>Password</b></label>
                                <input class="form-control" placeholder="Enter Password" type="password" name="EMPASSWORD"
                                    required>
                            </p>
                            <hr class="mb-3">

                            <p>By logging in your account you agree to our <a href="#">Terms & Privacy</a>.</p>
                            <input class="btn btn-primary" type="submit" name="emcreate" value="Login">
                            <p>
                            <p>Not an Employee? Click <a href="index.php">here</a> to go back to SMP.</p>
                            </p>
                        </div>

                        <div class="col">
                        </div>

                        <div class="col">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <?php
            if (isset($_POST['emcreate'])) {

                $emusername = $_POST['EMUSER_NAME'];
                $empassword = $_POST['EMPASSWORD'];

                $db = new SQLite3('database/SMP.db');
                $query = "SELECT * FROM EM_INFO WHERE EMUSER_NAME = '$emusername' and EMPASSWORD = '$empassword'";
                $result = $db->querysingle($query);

                if ($result) {
                    $_SESSION['emuser_name'] = $emusername;
                    echo "<script>location.href = 'emindex.php'</script>";
                } else {
                    echo '<p style="padding-left:70px; color:red;">Incorrect Username or Password!</p>';

                }
            }
            ?>
        </div>
    </div>
</body>

</html>