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
    <script src="https://asset.sharpxchange.com/assets/js/sharpxchange.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
</head>
<?php 

session_start();
require 'xsrf.php';
require "dbconnect.php";
require "helpertwo.php";
require "helper.php";
require "header.php";

if (isset($_SESSION['user_login_session'])) {
    header('Location: /');
    exit();
}

if (isset($_GET['error'])) {
    $error = "Please Login or create an account.";
} else {
    $error = "";
}

if (isset($_SESSION['badIP'])) {
    header("HTTP/1.1 401 Unauthorized");
    header("Location: /block");
    die();
}

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sxc_Signin_btn'])) {
    $sxc_Email  = validate_input($_POST['sxc_Signin_Email']);
    $sxc_Passwd = validate_input($_POST['sxc_Signin_Password']);
    $status     = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);

    //echo $sxc_Email . " : " . $sxc_Passwd;
    if (!$status) {
        $error = "CSRF FAILED!";
    } else {
        if (empty($sxc_Email) || empty($sxc_Passwd)) {
            $error = "All fields are required.";
        } else {
            if (isset($_SESSION['badIP'])) {
                header("HTTP/1.1 401 Unauthorized");
                header("Location: /block");
            } else {
                $sqlQuery       = "SELECT `username`, `passwd` FROM `tbl_user_info` WHERE `email` = '$sxc_Email'";
                $result         = mysqli_query($dbconnect, $sqlQuery);
                $rows           = mysqli_fetch_array($result);
                $store_password = $rows['passwd'];
                $sxc_username   = $rows['username'];
                $check          = password_verify($sxc_Passwd, $store_password);
                $code           = uniqid();
                // echo $store_password . " : ";
                // echo $sxc_username;
                if ($check) {


                    $session_id = getSessionToken($sxc_Email);
                    $md5uniqid  = md5(uniqid());
                    date_default_timezone_set("Asia/Dhaka");
                    $time       = date("Y-m-d h:i:sa");

                    if ($session_id == 0) {
                        $sqlSession = "INSERT INTO `tbl_user_sessiontoken`(`session_id`, `session_token`, `session_email`, `session_create`) VALUES ('$code','$md5uniqid','$sxc_Email','$time')";
                        $rsltSesion = mysqli_query($dbconnect, $sqlSession);
                        if ($rsltSesion) {
                            $_SESSION['user_login_session'] = $sxc_username;
                            $_SESSION['PHPSESSID'] = $md5uniqid;
                            echo '<script>document.cookie = "SharpXchange_Cookie='.$md5uniqid.'";</script>';
                            unset($_SESSION['failattempts']);
                            unset($_SESSION['badIP']);
                            echo "<script>javascript:document.location='/'</script>";
                        }
                    } else {
                        $sqldeltoken = "DELETE FROM `tbl_user_sessiontoken` WHERE `session_email` = '$sxc_Email'";
                        $resultdeltoken = mysqli_query($dbconnect, $sqldeltoken);
                        if ($resultdeltoken) {
                            $sqlSession = "INSERT INTO `tbl_user_sessiontoken`(`session_id`, `session_token`, `session_email`, `session_create`) VALUES ('$code','$md5uniqid','$sxc_Email','$time')";
                            $rsltSesion = mysqli_query($dbconnect, $sqlSession);
                            if ($rsltSesion) {
                                $_SESSION['user_login_session'] = $sxc_username;
                                $_SESSION['PHPSESSID'] = $md5uniqid;
                                echo '<script>document.cookie = "SharpXchange_Cookie='.$md5uniqid.'";</script>';
                                unset($_SESSION['failattempts']);
                                unset($_SESSION['badIP']);
                                echo "<script>javascript:document.location='/'</script>";
                            }
                        }
                    }
                }else{
                    $error = "Username or Password Invalid.";
                    //implement ratelimit
                    $ip = get_ip_address();
                    if (isset($_SESSION['failattempts'])) {
                        $failattempt = $_SESSION['failattempts'];
                        $failattempt++;
                        $_SESSION['failattempts'] = $failattempt;
                        if ($_SESSION['failattempts'] >= 6) {
                            $error = "Too many request.";
                            header("HTTP/1.1 429 Too Many Requests");
                        }
                        /* Rate limiting user request */
                        if ($_SESSION['failattempts'] >= 16) {
                            $_SESSION['badIP'] = $ip;
                            header("HTTP/1.1 401 Unauthorized");
                        }
                    }else{
                        $failattempt = 1;
                        $_SESSION['failattempts'] = $failattempt;
                    }
                }
            }
        }
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
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-8 col-xl-8">
                <form class="contactsection sharpxchange-main" method="post" action="<?php echo htmlspecialchars("/signin");?>">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Login</h2>
                    <div class="form-group row mt-3 justify-content-md-center">
                        <div class="col-sm-12 col-md-12">
                            <p id="error">
                                <?php
                                    if ($error) {
                                        echo $error;
                                    }
                                ?>
                            </p>
                            <p id="success"></p>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="sxcSignupEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="sxcSigninEmail" name="sxc_Signin_Email">
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
                            <button class="btn btn-outline-sxc mr-auto p-2 bd-highlight" type="button" id="showpassword">Show Password</button>
                            <a class="p-2 bd-highlight" href="/confirmEmail">Forget Password?</a>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 d-flex bd-highlight">
                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                            <p class="mt-2">Create a account? </p><a class="mr-auto bd-highlight ml-2 mt-2" href="signup">Signup</a>
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
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5ca249e21de11b6e3b064991/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
</body>
</html>