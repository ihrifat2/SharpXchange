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
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/style.css">
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
    <script src="https://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
</head>
<?php 

session_start();
require "dbconnect.php";
require "hash.php";

if (!isset($_GET['token']) || !isset($_GET['code'])) {
    header('Location: /error');
}

$token  = validate_input($_REQUEST['token']);
$code   = validate_input($_GET['code']);

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$code   = decode($code);

$sqlQuery   = "SELECT `token`, `email`, `expire` FROM `tbl_token` WHERE `token_id` = '$code'";
$result     = mysqli_query($dbconnect, $sqlQuery);
$rows       = mysqli_fetch_array($result);
$storeToken = $rows['token'];
$email      = $rows['email'];
$expire     = $rows['expire'];

date_default_timezone_set("Asia/Dhaka");
$today = date("Y-m-d h:i:sa");
$token = rawurlencode($token);
$token = str_replace("%20", "+", $token);
$token = str_replace("%2F", "/", $token);

if (empty($storeToken) || empty($email) || empty($expire)) {
    $message = "<center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Account activation token has expired or not found.</center>";
} else {
    if ($today <= $expire) {
        if ($storeToken == $token) {
            $sqlstatus  = "UPDATE `tbl_user_info` SET `acc_active`=1 WHERE `email` = '$email'";
            $resultsts  = mysqli_query($dbconnect, $sqlstatus);
            $sqldelete = "DELETE FROM `tbl_token` WHERE `token_id` = '$code'";
            $resultdel = mysqli_query($dbconnect, $sqldelete);
            if ($resultsts && $resultdel) {
                $message = "<center><img src='https://asset.sharpxchange.com/assets/img/ok.png' height='120px'><br><br>Account activated.</center>";
            }
        } else {
            $message = "<center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Account activation token has expired or not found.</center>";
        }
    } else {
        $message = "<center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Account activation token has expired or not found.</center>";
    }
}

?>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-md-6 pt-1 sharpxchange-header-nav-left">
                    <a class="sharpxchange-header-logo text-dark" href="/">
                        <img src="https://asset.sharpxchange.com/assets/img/logo.png">
                    </a>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
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
                        <a class="nav-link" href="/">EXCHANGE</a>
                        <a class="nav-link" href="testimonials">TESTIMONIALS</a>
                        <a class="nav-link" href="contact">CONTACT</a>
                        <a class="nav-link" href="about">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
                <div class="contactsection sharpxchange-main">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Account Activation Status</h2>
                    <div class="form-group row justify-content-md-center">
                        <p class="ml-3 mr-3 text-justify">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            }
                            ?>
                        </p>
                    </div>
                </div>
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
                            <a href="/">Exchanger</a>
                        </li>
                        <li>
                            <a href="testimonials">Testimonials</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li>
                            <a href="policy">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="about">About Us</a>
                        </li>
                        <li>
                            <a href="contact">Contact</a>
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
</body>
</html>