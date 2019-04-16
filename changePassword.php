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

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <script src="https://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
</head>
<?php 

session_start();
require "dbconnect.php";
require "hash.php";
require 'xsrf.php';
require "helper.php";
require "mail.php";
require "header.php";

if (!isset($_GET['token']) || !isset($_GET['code'])) {
    header('Location: /error');
}

$token  = validate_input($_REQUEST['token']);
$token  = rawurlencode($token);
$token  = str_replace("%20", "+", $token);
$token  = str_replace("%2F", "/", $token);
$code1  = validate_input($_GET['code']);
$code2  = decode($code1);
$error  = "";

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$sqlQuery   = "SELECT `token`, `email`, `expire` FROM `tbl_token` WHERE `token_id` = '$code2'";
$result     = mysqli_query($dbconnect, $sqlQuery);
$rows       = mysqli_fetch_array($result);
$storeToken = $rows['token'];
$email      = $rows['email'];
$expire     = $rows['expire'];

date_default_timezone_set("Asia/Dhaka");
$today = date("Y-m-d h:i:sa");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sxc_CngPass_btn'])) {
    
    $newPasswd  = validate_input($_POST['sxc_New_Passwd']);
    $conPasswd  = validate_input($_POST['sxc_Con_Passwd']);
    $status     = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);

    $subject    = "Your account password is changed";
    $body       = '<div style="font-family: Bookman Old Style; font-size:18px; background-color: #ecf3fa; padding: 40px;"><center><img src="https://i.imgur.com/j8L9svN.png"></center><p>Hi!</p><p>You password is successfully updated. If you think, you did not request for resetting your password please <a href="/contact">let us know</a>.</p><p>Thanks,<br>From team SharpXchange</p></div>';

    if (!$status) {
        $error = "CSRF FAILED!";
    } else {
        if($newPasswd == $conPasswd && strlen($newPasswd) == strlen($conPasswd)) {
            if (strlen($newPasswd) < 8) {
                $error = "Password too short. Password must be eight character long";
            } else {

                $email_count = checkEmail($email);
                if($email_count>0) {
                    $newPasswd  = password_hash($conPasswd, PASSWORD_BCRYPT);
                    $sqlpassup  = "UPDATE `tbl_user_info` SET `passwd`='$newPasswd' WHERE `email` = '$email'";
                    $resultup   = mysqli_query($dbconnect, $sqlpassup);
                    if ($resultup) {

                        $sqlQuery       = "SELECT `first_name`,`last_name` FROM `tbl_user_info` WHERE `email` = '$email'";
                        $result         = mysqli_query($dbconnect, $sqlQuery);
                        $rows           = mysqli_fetch_array($result);
                        $first_name     = ucfirst($rows['first_name']);
                        $last_name      = ucfirst($rows['last_name']);
                        $fullname       = $first_name . " " . $last_name;
                        
                        $sqldeltoken    = "DELETE FROM `tbl_token` WHERE `token_id` = '$code2'";
                        $resultdeltoken = mysqli_query($dbconnect, $sqldeltoken);
                        if ($resultdeltoken) {
                            sendmail($email, $fullname, $subject, $body, $body);
                            $error = 54321;
                        }
                    } else {
                        $error = 12345;
                    }
                } else {
                    $error = 12345;
                }
            }
        } else {
            $error = "Password Not Matched.";
        }
    }
}

generateSessionToken();

if (empty($storeToken) || empty($expire)) {
    $message = "<div class='form-group row justify-content-md-center'><p class='ml-3 mr-3 text-justify'><center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Password reset token has expired or not found.</center></p></div>";
} else {
    if ($today <= $expire) {
        if ($storeToken == $token) {
            $message = '<div class="form-group row mt-3">
                    <label for="sxcNewPasswd" class="col-sm-4 col-form-label">New Password : </label>
                    <div class="col-sm-8 col-md-8">
                        <input type="password" class="form-control" id="sxcNewPasswd" name="sxc_New_Passwd" required>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="sxcConPasswd" class="col-sm-4 col-form-label">Confirm Password : </label>
                    <div class="col-sm-8 col-md-8">
                        <input type="password" class="form-control" id="sxcConPasswd" name="sxc_Con_Passwd" required>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-12 d-flex align-items-end flex-column bd-highlight">
                        <input type="hidden" name="csrf_token" value="'.tokenField().'">
                        <button class="btn btn-outline-sxc mt-auto p-2 bd-highlight" id="sxcConfirmbtn" type="submit" name="sxc_CngPass_btn">Confirm</button>
                    </div>
                </div>';
        } else {
            $message = "<div class='form-group row justify-content-md-center'><p class='ml-3 mr-3 text-justify'><center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Password reset token has expired or not found.</center></p></div>";
        }
    } else {
        $message = "<div class='form-group row justify-content-md-center'><p class='ml-3 mr-3 text-justify'><center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Password reset token has expired or not found.</center></p></div>";
    }
}

if ($error == 12345) {
    $message = "<div class='form-group row justify-content-md-center'><p class='ml-3 mr-3 text-justify'><center><img src='https://asset.sharpxchange.com/assets/img/wrong.png' height='100px'><br><br>Password reset token has expired or not found. Please try again.</center></p></div>";
    $error  = "";
}

if ($error == 54321) {
    $message = "<div class='form-group row justify-content-md-center'><p class='ml-3 mr-3 text-justify'><center><img src='https://asset.sharpxchange.com/assets/img/ok.png' height='120px'><br><br>Password Updated. You can login with your new password</center></p></div>";
    $error  = "";
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
                <form class="contactsection sharpxchange-main" method="post" action="<?php echo htmlspecialchars("/changePassword?token=$token&code=$code1");?>">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Change Password</h2>
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <p id="error">
                        <?php
                        if (isset($error)) {
                            echo $error;
                        }
                        ?>
                    </p>
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