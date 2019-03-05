<?php 

session_start();
if (isset($_SESSION['user_login_session'])) {
    header('Location: index.php');
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SharpXchange">
    <meta name="author" content="Imran Hadid">
    <meta name="generator" content="Imran">
    <title>SharpXchange</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 sharpxchange-header-nav-left">
                    <a class="text-muted" href="signup.php">Registration</a>
                    <a>/</a>
                    <a class="text-muted" href="signup.php">login</a>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center">
                    <a class="sharpxchange-header-logo text-dark" href="index.php">SharpXchange</a>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
                    <a class="text-muted">
                        Work time: 10:00 - 20:00, GMT +6
                    </a>
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mt-3 mb-3">
            <header class="masthead mb-auto">
                <div class="inner">
                    <nav class="nav nav-masthead justify-content-end">
                            <a class="nav-link" href="index.php">EXCHANGE</a>
                            <a class="nav-link" href="testimonials.html">TESTIMONIALS</a>
                            <a class="nav-link" href="contact.html">CONTACT</a>
                            <a class="nav-link" href="aboutUs.html">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-8 col-xl-8">
                <form class="contactsection sharpxchange-main" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Login</h2>
                    <div class="form-group row mt-3 justify-content-md-center">
                        <div class="col-sm-12 col-md-12">
                            <p id="error"></p>
                            <p id="success"></p>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="sxcSignupEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sxcSigninEmail" name="sxc_Signin_Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sxcSignupPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="sxcSigninPassword" name="sxc_Signin_Password">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 d-flex bd-highlight">
                            <button class="btn btn-outline-sxc bd-highlight" type="button" id="showpassword">Show Password</button>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 d-flex bd-highlight">
                            <p class="mt-2">Create a account? </p><a class="mr-auto bd-highlight ml-2 mt-2" href="signup.php">Signup</a>
                            <button class="btn btn-outline-sxc bd-highlight" type="submit" name="sxc_Signin_btn">login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="sharpxchange-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Quick access</h3>
                    <ul>
                        <li>
                            <a href="index.php">Exchanger</a>
                        </li>
                        <li>
                            <a href="testimonials.html">Testimonials</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li>
                            <a href="policy.html">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="aboutUs.html">About Us</a>
                        </li>
                        <li>
                            <a href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Contact Information</h3>
                    <ul>
                        <li>Email : </li>
                        <li>Facebook : </li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="mt-3">Copyright © 2019. SharpXchange</p>
        <p><a href="#">Back to top</a></p>
    </footer>
    <script src="assets/js/sharpxchange.js"></script>
</body>
</html>
<?php

require "dbconnect.php";
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sxc_Signin_btn'])) {
    $sxc_Signin_Email       = validate_input($_POST['sxc_Signin_Email']);
    $sxc_Signin_Password    = validate_input($_POST['sxc_Signin_Password']);

    //echo $sxc_Signin_Email . " : " . $sxc_Signin_Password;

    if (empty($sxc_Signin_Email) || empty($sxc_Signin_Password)) {
        echo "<script>document.getElementById('error').innerHTML = 'All fields are required';</script>";
    } else {
        $sqlQuery       = "SELECT * FROM `db_user_info` WHERE `email` = '$sxc_Signin_Email'";
        $result         = mysqli_query($dbconnect, $sqlQuery);
        $rows           = mysqli_fetch_array($result);
        $store_password = $rows['passwd'];
        $sxc_username   = $rows['username'];
        $check          = password_verify($sxc_Signin_Password, $store_password);
        // echo $store_password . " : ";
        // echo $sxc_username;
        if ($check) {
            $_SESSION['user_login_session'] = $sxc_username;
            //header('Location: index.php');
            echo "<script>javascript:document.location='index.php'</script>";
        }else{
            echo "<script>document.getElementById('error').innerHTML = 'Username or Password Invalid.';</script>";
        }
    }
}
?>