<?php
session_start();
require "dbconnect.php";
require "usersqlhelper.php";
require "auth.php";
$username   = $_SESSION['user_login_session'];
$firstName  = getfirstname($username);
$lastName   = getlastname($username);
$phnnmbr    = getphonenumber($username);
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
    <link rel="stylesheet" href="assets/css/accountupdate.css">

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
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sharpxchange.js"></script>
</head>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <?php
                    if (isset($_SESSION['user_login_session'])) {
                        echo '
                        <div class="col-sm-4 col-md-4 pt-1 sharpxchange-header-nav-left dropdown">
                            <a class="btn btn-outline-sxc dropdown-toggle" href="#" role="button" id="accountDetails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Settings
                            </a>

                            <div class="dropdown-menu" aria-labelledby="accountDetails">
                                <a class="dropdown-item" href="account.php">Account Settings</a>
                                <a class="dropdown-item" href="exchange.php">Exchange Details</a>
                                <a class="dropdown-item" href="testimonial.php">Testimonial</a>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="col-sm-4 col-md-4 pt-1 sharpxchange-header-nav-left">
                            <a class="text-muted" href="signup.php">Registration</a>
                            <a>/</a>
                            <a class="text-muted" href="signin.php">login</a>
                        </div>
                        ';
                    }
                ?>
                <div class="col-sm-4 col-md-4 text-center">
                    <a class="sharpxchange-header-logo text-dark" href="index.php">SharpXchange</a>
                </div>
                <div class="col-sm-4 col-md-4 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
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
                        <a class="nav-link active" href="contact.html">CONTACT</a>
                        <a class="nav-link" href="aboutUs.html">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="line"></div>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav nav-tabs flex-column">
                        <li class="active nav-item">
                            <a class="nav-link" data-toggle="tab" href="#home">
                                Change Profile Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#messages">
                                Change Email
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#settings">
                                Change Password
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-9 pt-3 px-4">
                <div class="tab-content">
                    <p id="error"></p>
                    <p id="success">
                        <?php 
                            if (isset($_SESSION['success'])) {
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            }
                        ?>
                    </p>
                    <div class="tab-pane fade in active mt-3" id="home">
                        <form class="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="first_name"><h4>First name</h4></label>
                                    <input type="text" class="form-control" name="changeFirstName" id="first_name" placeholder="First name" value="<?php echo ucfirst($firstName); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="last_name"><h4>Last name</h4></label>
                                    <input type="text" class="form-control" name="changeLastName" id="last_name" placeholder="Last name" value="<?php echo ucfirst($lastName); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="phone"><h4>Phone</h4></label>
                                    <input type="text" class="form-control" name="changePhone" id="phone" placeholder="Phone Number" value="<?php echo $phnnmbr; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="1" selected>Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-outline-sxc" type="submit" name="changeAccountInfo">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade mt-3" id="messages">
                        <form class="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="email"><h4>New Email</h4></label>
                                    <input type="email" class="form-control" name="changeNewEmail" id="email" placeholder="Your@email.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password"><h4>Password</h4></label>
                                    <input type="password" class="form-control" name="changeNEPassword" id="passwdEmCh" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-outline-sxc" type="submit" name="changeEmail">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade mt-3" id="settings">
                        <form class="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password"><h4>Old Password</h4></label>
                                    <input type="password" class="form-control" name="changeOldPassword" id="oldpassword" placeholder="Old Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password"><h4>New Password</h4></label>
                                    <input type="password" class="form-control" name="changeNewPassword" id="newpassword" placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password"><h4>Confirm New Password</h4></label>
                                    <input type="password" class="form-control" name="changeConPassword" id="conpassword" placeholder="Confirm New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-outline-sxc" type="submit" name="changePassword">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <footer class="sharpxchange-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Quick access</h3>
                    <ul>
                        <li><a href="index.php">Exchanger</a></li>
                        <li><a href="testimonials.html">Testimonials</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li><a href="policy.html">Privacy Policy</a></li>
                        <li><a href="aboutUs.html">About Us</a></li>
                        <li><a href="contact.html">Contact</a></li>
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
<?php

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['changeAccountInfo'])) {
    $changeFname = validate_input($_POST['changeFirstName']);
    $changeLname = validate_input($_POST['changeLastName']);
    $changephNum = validate_input($_POST['changePhone']);
    $gender      = validate_input($_POST['gender']);
    if ($gender == 1) {
        $gender = "Male";
    } else {
        $gender = "Female";
    }
    // echo $gender;
    if (empty($changeFname)) {
        $changeFname = getfirstname($username);
    }
    if (empty($changeLname)) {
        $changeLname = getlastname($username);
    }
    // echo "<br>";
    // echo $changephNum;
    // echo "<br>";
    if (empty($changephNum)) {
        $changephNum = getphonenumber($username);
        if (empty($changephNum)) {
            $changephNum = "";
        }
    }
    // echo $changephNum;
    // echo "<br>";
    if (empty($gender)) {
        $gender = getgender($username);
    }
    $dt         = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $time       = $dt->format('F j, Y, l g:i a');
    $time       = validate_input($time);
    $sqlQuery   = "UPDATE `tbl_user_info` SET `first_name` = '$changeFname',`last_name` = '$changeLname',`phone` = '$changephNum', `gender` = '$gender', `acc_update` = '$time' WHERE `username` = '$username'";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    // $result = 0;
    if ($result) {
        $_SESSION['success'] = "Account Info Updated.";
        // echo "<script>document.getElementById('success').innerHTML = 'Account Info Updated.'</script>";
        //header('Location : index.php');
        echo "<script>javascript:document.location='account.php'</script>";
    } else {
        // echo mysqli_error($dbconnect);
        echo "<script>document.getElementById('error').innerHTML = 'Account Info Update Failed.'</script>";
    }
}
if (isset($_POST['changeEmail'])) {
    $changeEmail = validate_input($_POST['changeNewEmail']);
    $changePaswd = validate_input($_POST['changeNEPassword']);
    $matchpasswd = matchPassword($username, $changePaswd);
    if (empty($changeEmail) || empty($changePaswd)) {
        echo "<script>document.getElementById('error').innerHTML = 'All fields are required.'</script>";
    } else {
        if ($matchpasswd) {
            $sqlQuery   = "UPDATE `tbl_user_info` SET `email`='$changeEmail' WHERE `username` = '$username'";
            $result     = mysqli_query($dbconnect, $sqlQuery);
            if ($result) {
                $_SESSION['success'] = "Email Address Updated.";
                echo "<script>javascript:document.location='account.php'</script>";
                // echo "<script>document.getElementById('success').innerHTML = 'Email Address Updated.'</script>";
            } else {
                echo "<script>document.getElementById('success').innerHTML = 'Email Address Updated failed.'</script>";
            }
        } else {
            echo "<script>document.getElementById('error').innerHTML = 'Incorrect Password.'</script>";
        }
    }
}
if (isset($_POST['changePassword'])) {
    $changeOPswd = validate_input($_POST['changeOldPassword']);
    $changeNPswd = validate_input($_POST['changeNewPassword']);
    $changeCPswd = validate_input($_POST['changeConPassword']);
    $matchpasswd = matchPassword($username, $changeOPswd);
    if (empty($changeOPswd) || empty($changeNPswd) || empty($changeCPswd)) {
        echo "<script>document.getElementById('error').innerHTML = 'All fields are required.'</script>";
    } else {
        if ($matchpasswd) {
            if ($changeNPswd == $changeCPswd) {
                if (strlen($changeNPswd) < 8) {
                    echo "<script>document.getElementById('error').innerHTML = 'Password too short. Password must be eight character long'</script>";
                } else {
                    $changeNPswd    = password_hash($changeNPswd, PASSWORD_BCRYPT);
                    $sqlQuery       = "UPDATE `tbl_user_info` SET `passwd`='$changeNPswd' WHERE `username` = '$username'";
                    $result         = mysqli_query($dbconnect, $sqlQuery);
                    if ($result) {
                        $_SESSION['success'] = "Password Updated.";
                        echo "<script>javascript:document.location='account.php'</script>";
                        // echo "<script>document.getElementById('success').innerHTML = 'Password Updated.'</script>";
                    } else {
                        echo "<script>document.getElementById('error').innerHTML = 'Password Update Failed.'</script>";
                    }
                }
            } else {
                echo "<script>document.getElementById('error').innerHTML = 'Password Not Matched.'</script>";
            }
        } else {
            echo "<script>document.getElementById('error').innerHTML = 'Incorrect Old Password.'</script>";
        }
    }
}
?>