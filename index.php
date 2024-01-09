<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/MP-NAV.css">

    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&family=Ubuntu:wght@300&display=swap"
    rel="stylesheet"> -->

    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <style>
        section {
            /* background-image: url('Images/image-lowgrey.jpg'); */
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>

</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user_name'])) {
        $_SESSION['user_name'] = 'Guest';
        $_SESSION['themecolour'] = 'rgb(250, 250, 250)';
        $_SESSION['bodytheme'] = 'grey';
        $_SESSION['homeimage'] = 'url("Images/image-lowgrey.jpg")';
    }
    ?>
    <div class='header' style='background-color:<?php echo $_SESSION["themecolour"] ?>;'>
        <div class="row">
            <div class="col">
                <h1><a style="text-decoration:none;color:black;" href="index.php">Smart Meal Planner</a></h1>
            </div>
            <div class="col">
                <p style="text-align:right;">Welcome,<br><b>
                        <?php echo $_SESSION['user_name'] ?>
                    </b></p>
            </div>
        </div>
    </div>

    <div class="topnav" style='background-color:<?php echo $_SESSION["themecolour"] ?>;'>
        <nav>
            <a class="active" href="index.php"><i class="bi-house-fill"></i> Home</a>
            <a href="HowitWorks.php"><i class="bi-tags"></i> How it Works</a>
            <a href="BrowseFood.php"><i class="bi-layout-text-sidebar-reverse"></i> Browse Food</a>
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

    <div class="main1" style="padding-left:0px;padding-right:0px;padding-top:55px;">

        <section id="title" style='background-image:<?php echo $_SESSION["homeimage"] ?>;'>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6" style="padding-top:65px;">
                        <h1 style="font-family: 'Montserrat', sans-serif;font-size: 3.5rem;line-height: 1.5;">
                            <b><b>Good and Healthy<br>Food For Your<br>Everyday Life.</b></b>
                        </h1>
                    </div>
                    <div class="col-lg-6">
                        <img style="border-radius:16px;" class="title-image" src="Images/SMP_Logo.jpg" alt="...">
                    </div>
                </div>
            </div>
        </section>

        <div id="features">
            <div class="container-fluid">
                <div class="row">
                    <div class="feature-box col-lg-4">
                        <i class="icon fas fa-check-circle fa-4x"></i>
                        <h4><b>Prescribed Meal Plan.</b></h4>
                        <p style="color:#8f8f8f;"><b>Options are displayed according to your lifestyle.</b></p>
                    </div>
                    <div class="feature-box col-lg-4">
                        <i class="icon fas fa-utensils fa-4x"></i>
                        <h4><b>Healthy food.</b></h4>
                        <p style="color:#8f8f8f;"><b>We use the best products available and deliver it hot and ready to
                                eat.</b></p>
                    </div>
                    <div class="feature-box col-lg-4">
                        <i class="icon fas fa-motorcycle fa-4x"></i>
                        <h4><b>Timely Delivery.</b></h4>
                        <p style="color:#8f8f8f;"><b>We have fixed timings to deliver well packaged food from our
                                vendors.</b></p>
                    </div>
                    <div class="feature-box col-lg-4">
                        <i class="icon fas fa-pizza-slice fa-4x"></i>
                        <h4><b>Follow any eating style or create your own.</b></h4>
                        <p style="color:#8f8f8f;"><b>You can customize popular eating styles like veg and nonveg
                                to match your needs and preferences.</b>
                        </p>
                    </div>
                    <div class="feature-box col-lg-4">
                        <i class="icon fas fa-th-list fa-4x"></i>
                        <h4><b>Easy to choose.</b></h4>
                        <p style="color:#8f8f8f;"><b>You can either choose meals which is calculated by BMI, or simply
                                automate a balanced meal plan.</b>
                        </p>
                    </div>
                    <div class="feature-box col-lg-4">
                        <i class="icon fas fa-user-ninja fa-4x"></i>
                        <h4><b>Take the anxiety out of picking what to eat.</b></h4>
                        <p style="color:#8f8f8f;"><b>Make the important decisions ahead of time and on your
                                own schedule.</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="testimonials" style='background-color:<?php echo $_SESSION["bodytheme"] ?>;'>
            <div id="testimonials-carousel" class="carousel slide" data-ride="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h2>The Meal Planner perfectly works with my lifestyle. Always delivered on time.</h2>
                        <img class="testimonial-image" src="Images/dog.jpg" alt="dog-profile">
                        <em>Ranjit, New Delhi</em>
                    </div>
                    <div class="carousel-item">
                        <h2 class="testimonial-text">I used to eat fast food everday thanks to SMP I have had a
                            healthy diet since then.</h2>
                        <img class="testimonial-image" src="Images/lady.jpg" alt="lady-profile">
                        <em>Candice, Bangalore</em>
                    </div>
                    <div class="carousel-item">
                        <h2 class="testimonial-text">The ingredients that are send are top quality and recipe is easy to
                            understand.</h2>
                        <img class="testimonial-image" src="Images/adam.jpg" alt="man-profile">
                        <em>Chris, Goa</em>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#testimonials-carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#testimonials-carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div id="press" style='background-color:<?php echo $_SESSION["bodytheme"] ?>;'>
            <img class="press-logo" src="Images/forbes.jpg" alt="tc-logo" href="https://www.forbesindia.com">
            <img class="press-logo" src="Images/thehindu.jpg" alt="tnw-logo">
            <img class="press-logo" src="Images/toi_red.jpg" alt="biz-insider-logo">
            <img class="press-logo" src="Images/mashable.jpg" alt="mashable-logo" href="https://mashable.com">
        </div>

        <div id="feedback">
            <div>
                <h2 id="heading"><b>Feedback</b></h2>
                <br>
                <br>
                <form class="feedbackform" action="#feedback" method="post">
                    <div class="container">
                        <label for="Email id"><b>Email ID:</b></label><br>
                        <input class="form-control" placeholder="Enter your Email" id="email" type="email" name="EMAIL"
                            required>
                        <br>
                        <label for="Name"><b>Name:</b></label><br>
                        <input class="form-control" placeholder="Enter your Name" id="name" type="text" name="NAME"
                            required>
                        <br>
                        <label for="feedback"><b>Your valuable feedback:</b></label><br>
                        <textarea class="form-control" placeholder="Enter your Feedback" id="Feedback" name="FEEDBACK"
                            rows="7" cols="33" required></textarea>
                        <input class="btn btn-primary" type="submit" name="Submit" value="Submit">

                        <div>
                            <?php
                            if (isset($_POST['Submit'])) {
                                $name = $_POST['NAME'];
                                $emailaddress = $_POST['EMAIL'];
                                $feedback = $_POST['FEEDBACK'];

                                $db = new SQLite3('database/SMP.db');

                                $result = $db->exec("INSERT INTO FEEDBACK(NAME, EMAIL, COMMENTS) 
                                VALUES('$name', '$emailaddress', '$feedback')");

                                if ($result) {
                                    echo "<br><p style='color:darkblue;'><b>Thank you for the Feedback!</b></p>";
                                } else {
                                    echo "<p style='color:red;'><b>Error in submitting Feedback!</b></p>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer id="footer" style='background-color:<?php echo $_SESSION["bodytheme"] ?>;'>
            <a href="https://www.twitter.com"><i class="icon-2 bi bi-twitter"></i></a>
            <a href="https://www.facebook.com"><i class="icon-2 bi bi-facebook"></i></a>
            <a href="https://www.instagram.com"><i class="icon-2 bi bi-instagram"></i></a>
            <a href="https://www.gmail.com"><i class="icon-2 bi bi-envelope"></i></a>

            <p>
            <p style="color:white;"><b>© Copyright 2023</b></p>
            </p>
        </footer>
    </div>
</body>

</html>