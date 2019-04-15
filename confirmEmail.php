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
    <link rel="stylesheet" href="http://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://asset.sharpxchange.com/assets/css/style.css">
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
    <script src="http://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="http://asset.sharpxchange.com/assets/js/sharpxchange.js"></script>
    <script src="http://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
</head>
<?php 

session_start();
require "dbconnect.php";
require "hash.php";
require 'xsrf.php';
require "helper.php";

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sxc_Confirm_btn'])) {
    $email = validate_input($_POST['sxc_Confirm_email']);

    $sqlQuery       = "SELECT `first_name`,`last_name` FROM `tbl_user_info` WHERE `email` = '$email'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $first_name     = ucfirst($rows['first_name']);
    $last_name      = ucfirst($rows['last_name']);
    $fullname       = $first_name . " " . $last_name;
    $status         = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);

    $email_count = checkEmail($email);
    $token      = $email; 
    $token      = encrypt($token);
    $code       = uniqid();
    $code2      = encode($code);
    $subject    = "Recover your account password";
    $body       = '<div style="font-family: Bookman Old Style; font-size:18px; background-color: #ecf3fa; padding: 40px;"><center><img src="https://i.imgur.com/j8L9svN.png"></center><p>Hi!</p><p>You recently requested to reset your password for your account. Use the button below to reset your password.<b> This reset password token is valid for the next 24 hours</b></p><br><a style="padding: 20px; background-color: #9a0202; color: white; text-decoration: none;border-radius: 5px;" href="https://'.$_SERVER["SERVER_NAME"].'/changePassword?token='.$token.'&code='.$code2.'">Reset your password</a><br><br><p>If you think, you did not request for resetting your password please <a href="/contact">let us know</a>.</p><p>Thanks,<br>From team SharpXchange</p></div>';
    date_default_timezone_set("Asia/Dhaka");
    $today = date("Y-m-d h:i:sa");
    $d = strtotime("+1 day");
    $tomorrow = date("Y-m-d h:i:sa", $d);

    if($email_count>0) {
        if (!$status) {
            $message = "CSRF FAILED!";
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                // If there is an another token available for the email then delete pervious one and generate new one
                $sqldeltoken = "DELETE FROM `tbl_token` WHERE `email` = '$email'";
                $resultdeltoken = mysqli_query($dbconnect, $sqldeltoken);
                if ($resultdeltoken) {
                    $sqlConMail = "INSERT INTO `tbl_token`(`token_id`, `token`, `email`, `create`, `expire`) VALUES ('$code','$token','$email','$today','$tomorrow')";
                    $resultConMail = mysqli_query($dbconnect, $sqlConMail);
                    if ($resultConMail) {
                        require "mail/index.php";
                        sendmail($email, $fullname, $subject, $body, $body);
                        $message = "An email has been sent to (provided email address) with further instructions. Please check your email address.";
                    }
                } else {
                    $message = "error.";
                }
            } else {
                $message = "Invalid Email";
            }
        }
    } else {
        $message = "We couldn’t find a user with that email address.";
    }
}
generateSessionToken();
?>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-md-6 pt-1 sharpxchange-header-nav-left">
                    <a class="sharpxchange-header-logo text-dark" href="/">
                        <img src="http://asset.sharpxchange.com/assets/img/logo.png">
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
                <form class="contactsection sharpxchange-main" method="post" action="<?php echo htmlspecialchars("/confirmEmail");?>">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Confirm Email</h2>
                    <div class="form-group row mt-3">
                        <label for="sxcConfirmEmail" class="col-sm-2 col-form-label">Email : </label>
                        <div class="col-sm-10 col-md-10">
                            <input type="email" class="form-control" id="sxcConfirmEmail" name="sxc_Confirm_email" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center">
                        <p class="ml-3 mr-3 text-justify">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 d-flex align-items-end flex-column bd-highlight">
                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                            <button class="btn btn-outline-sxc mt-auto p-2 bd-highlight" id="sxcConfirmbtn" type="submit" name="sxc_Confirm_btn">Confirm</button>
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