<?php 

session_start();
require 'xsrf.php';
require "dbconnect.php";
require "helper.php";
require "helpertwo.php";
require "hash.php";

if (isset($_SESSION['user_login_session'])) {
    header('Location: index.php');
    exit();
}

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sxc_signup_btn'])) {
    $sxc_signup_fname       = validate_input($_POST['sxc_signup_fname']);
    $sxc_signup_fname       = ucfirst($sxc_signup_fname);
    $sxc_signup_lname       = validate_input($_POST['sxc_signup_lname']);
    $sxc_signup_lname       = ucfirst($sxc_signup_lname);
    $sxc_signup_username    = validate_input($_POST['sxc_signup_username']);
    $sxc_signup_email       = validate_input($_POST['sxc_signup_email']);
    $sxc_signup_paswd       = validate_input($_POST['sxc_signup_paswd']);
    $sxc_signup_conpaswd    = validate_input($_POST['sxc_signup_conpaswd']);
    $user_ip                = get_ip_address();
    $dt                     = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $time                   = $dt->format('F j, Y, l g:i a');
    $status                 = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $fullname               = $sxc_signup_fname . " " . $sxc_signup_lname;

    $token      = $sxc_signup_email . $sxc_signup_username; 
    $token      = encrypt($token);
    $code       = uniqid();
    $code2      = encode($code);
    $subject    = "Verify your account";
    $body       = '<div style="font-family: Bookman Old Style; font-size:18px; background-color: #e9d7d7; padding: 40px;"><center><img src="https://i.imgur.com/j8L9svN.png"><p>Thanks for registration in SharpXchange. We"re happy to have you here!</p><p>You can activate your account just by <a href="https://'.$_SERVER["SERVER_NAME"].'/active?token='.$token.'&code='.$code2.'">click here</a></p><br><p>All the best,<br>From team SharpXchange</p></center></div>';
    date_default_timezone_set("Asia/Dhaka");
    $today = date("Y-m-d h:i:sa");

    $d = strtotime("+1 day");
    $tomorrow = date("Y-m-d h:i:sa", $d);

    // echo $sxc_signup_fname . " : " . $sxc_signup_lname . " : " . $sxc_signup_username . " : " . $sxc_signup_email . " : " . $sxc_signup_paswd . " : " . $sxc_signup_conpaswd;

    if (!$status) {
        $error = "CSRF FAILED!";
    } else {
        if (empty($sxc_signup_fname) || empty($sxc_signup_lname) || empty($sxc_signup_username) || empty($sxc_signup_email) || empty($sxc_signup_paswd) || empty($sxc_signup_conpaswd)) {
            $error = "All fields are required";
        } else {
            $uname_count = checkUsername($sxc_signup_username);
            if($uname_count>0) {
                $error = "Username Not Available.";
            } else {
                $email_count = checkEmail($sxc_signup_email);
                if($email_count>0) {
                    $error = "Email Not Available.";
                } else {
                    if (filter_var($sxc_signup_email, FILTER_VALIDATE_EMAIL)) {
                        if (strlen($sxc_signup_paswd) <= 7) {
                            $error = "Password too short";
                        } else {
                            if ($sxc_signup_paswd != $sxc_signup_conpaswd) {
                                $error = "Password not matched";
                            } else {
                                $sxc_signup_encrypt_paswd = password_hash($sxc_signup_paswd, PASSWORD_BCRYPT);
                                $sqlQuery = "INSERT INTO `tbl_user_info`(`user_id`, `first_name`, `last_name`, `username`, `email`, `passwd`, `signup_time`, `signup_ip`) VALUES (NULL, '$sxc_signup_fname', '$sxc_signup_lname', '$sxc_signup_username', '$sxc_signup_email', '$sxc_signup_encrypt_paswd', '$time', '$user_ip')";
                                $sqlQuery2 = "INSERT INTO `tbl_token`(`token_id`, `token`, `create`, `expire`) VALUES ('$code','$token','$today','$tomorrow')";
                                $result = mysqli_query($dbconnect, $sqlQuery);
                                $result2 = mysqli_query($dbconnect, $sqlQuery2);
                                if ($result && $result) {
                                    //send mail
                                    require "mail/index.php";
                                    sendmail($sxc_signup_email, $fullname, $subject, $body, $body);
                                    $success = "Registration Successful. Please check your email address";
                                } else {
                                    $error = "Registration Failed";
                                }
                            }
                        }
                    } else {
                        $error = "Invalid Email";
                    }
                }
            }
        }
    }
}
generateSessionToken();
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
            <div class="col-sm-12 col-md-8">
                <form class="contactsection sharpxchange-main" method="post" action="<?php echo htmlspecialchars("/signup");?>">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Registration</h2>
                    <div class="form-group row mt-3 justify-content-md-center">
                        <div class="col-sm-12 col-md-12">
                            <p id="error">
                                <?php 
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                ?>
                            </p>
                            <p id="success">
                                <?php 
                                    if (isset($success)) {
                                        echo $success;
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6 col-md-6">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="sxcSignupFirstName" name="sxc_signup_fname" required>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="sxcSignupLastName" name="sxc_signup_lname" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="sxcSignupUsername" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10 col-md-10">
                            <input type="text" class="form-control" id="sxcSignupUsername" name="sxc_signup_username" onBlur="checkUsername()" required>
                            <div class="status" id="sxcUsernameStatus"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="sxcSignupEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10 col-md-10">
                            <input type="email" class="form-control" id="sxcSignupEmail" name="sxc_signup_email" onBlur="checkEmail()" required>
                            <div class="status" id="sxcEmailStatus"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="s" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10 col-md-10">
                            <input type="password" class="form-control" id="sxcSignupPassword" name="sxc_signup_paswd" onkeyup="checkpasswd()" required>
                            <div class="status" id="sxcPasswdStatus"></div>
                        </div>
                    </div>
                    <div class="form-group row hide" id="sxcSignupConfirmPassword">
                        <label for="sxcSignupConfirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10 col-md-10">
                            <input type="password" class="form-control" id="sxcSignupConPassword" name="sxc_signup_conpaswd" onkeyup="checkconpasswd()" required>
                            <div class="status" id="sxcConPasswdStatus"></div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 d-flex bd-highlight">
                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                            <p class="mt-2">Already have a account?</p><a class="mr-auto bd-highlight ml-2 mt-2" href="signin">Login</a>
                            <button class="btn btn-outline-sxc bd-highlight" id="sxcsignupbtn" type="submit" name="sxc_signup_btn" disabled>Registration</button>
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